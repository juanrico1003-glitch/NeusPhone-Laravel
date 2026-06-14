<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusMailable;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WompiController extends Controller
{
    // Callback de retorno (Redirección del cliente)
    public function callback(Request $request)
    {
        $transactionId = $request->query('id');

        if (!$transactionId) {
            return redirect()->route('pedidos.index')->with('error', 'No se proporcionó un ID de transacción válido.');
        }

        $mode = env('WOMPI_MODE', 'sandbox');
        $baseUrl = $mode === 'production' 
            ? 'https://production.wompi.co/v1' 
            : 'https://sandbox.wompi.co/v1';

        $pedido = null;
        $transactionData = null;
        $errorMsg = null;

        try {
            // Consultar el estado de la transacción en la API de Wompi
            $response = Http::withToken(env('WOMPI_PRIVATE_KEY'))
                ->get("{$baseUrl}/transactions/{$transactionId}");

            if ($response->successful()) {
                $transactionData = $response->json()['data'];
                $reference = $transactionData['reference'];
                $status = $transactionData['status'];

                // Buscar el pedido por la referencia de Wompi
                $pedido = Pedido::where('wompi_reference', $reference)->first();

                // Fallback de búsqueda parsing de la referencia (NEUS-ID-TIMESTAMP)
                if (!$pedido) {
                    $parts = explode('-', $reference);
                    if (count($parts) >= 2) {
                        $pedido = Pedido::find($parts[1]);
                    }
                }

                if ($pedido) {
                    $pedido->wompi_transaction_id = $transactionData['id'];
                    $pedido->wompi_payment_method = $transactionData['payment_method_type'] ?? null;
                    $pedido->wompi_status = $status;

                    $alreadyPaid = $pedido->getOriginal('estado') === 'pagado';

                    if ($status === 'APPROVED' && !$alreadyPaid) {
                        $pedido->estado = 'pagado';
                    }

                    $pedido->save();

                    if ($status === 'APPROVED' && !$alreadyPaid) {
                        $this->descontarStock($pedido);
                        $this->enviarNotificacionPedido($pedido);
                    }
                }
            } else {
                $errorMsg = 'No se pudo verificar el estado de la transacción con Wompi. Código: ' . $response->status();
                Log::error('Error consultando transacción Wompi: ' . $response->body());
            }
        } catch (\Exception $e) {
            $errorMsg = 'Ocurrió un error al procesar el pago: ' . $e->getMessage();
            Log::error('Excepción Wompi callback: ' . $e->getMessage());
        }

        return view('checkout.resultado', compact('pedido', 'transactionData', 'errorMsg'));
    }

    // Webhook asíncrono enviado por Wompi
    public function webhook(Request $request)
    {
        Log::info('Wompi Webhook recibido', $request->all());

        // Validar que sea un evento de actualización de transacción
        $event = $request->input('event');
        if ($event !== 'transaction.updated') {
            return response()->json(['status' => 'ignored'], 200);
        }

        // Opcional: Validar firma si el Event Secret (WOMPI_EVENTS_KEY) está configurado
        $eventSecret = env('WOMPI_EVENTS_KEY');
        if (!empty($eventSecret)) {
            if (!$this->validateSignature($request, $eventSecret)) {
                Log::warning('Firma de webhook de Wompi inválida');
                return response()->json(['status' => 'invalid_signature'], 400);
            }
        }

        $transaction = $request->input('data.transaction');
        if (!$transaction) {
            return response()->json(['status' => 'no_transaction_data'], 400);
        }

        $transactionId = $transaction['id'];

        // Consultar directamente a la API de Wompi por seguridad (evita suplantación de webhooks)
        $mode = env('WOMPI_MODE', 'sandbox');
        $baseUrl = $mode === 'production' 
            ? 'https://production.wompi.co/v1' 
            : 'https://sandbox.wompi.co/v1';

        try {
            $response = Http::withToken(env('WOMPI_PRIVATE_KEY'))
                ->get("{$baseUrl}/transactions/{$transactionId}");

            if ($response->successful()) {
                $data = $response->json()['data'];
                $reference = $data['reference'];
                $status = $data['status'];

                $pedido = Pedido::where('wompi_reference', $reference)->first();

                // Fallback de búsqueda
                if (!$pedido) {
                    $parts = explode('-', $reference);
                    if (count($parts) >= 2) {
                        $pedido = Pedido::find($parts[1]);
                    }
                }

                if ($pedido) {
                    $pedido->wompi_transaction_id = $data['id'];
                    $pedido->wompi_payment_method = $data['payment_method_type'] ?? null;
                    $pedido->wompi_status = $status;

                    $alreadyPaid = $pedido->getOriginal('estado') === 'pagado';

                    if ($status === 'APPROVED' && !$alreadyPaid) {
                        $pedido->estado = 'pagado';
                    }

                    $pedido->save();
                    Log::info("Pedido #{$pedido->id} actualizado via Webhook a estado: {$pedido->estado}");

                    if ($status === 'APPROVED' && !$alreadyPaid) {
                        $this->descontarStock($pedido);
                        $this->enviarNotificacionPedido($pedido);
                    }
                }

                return response()->json(['status' => 'processed'], 200);
            }
        } catch (\Exception $e) {
            Log::error('Excepción procesando Wompi Webhook: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['status' => 'not_found'], 404);
    }

    public function simular(Request $request)
    {
        $pedidoId = $request->query('pedido');
        $pedido = Pedido::where('id', $pedidoId)
            ->where('usuario_id', auth()->id())
            ->where('estado', 'pendiente')
            ->first();

        if (!$pedido) {
            return redirect()->route('pedidos.index')->with('error', 'Pedido no encontrado o ya procesado.');
        }

        $transactionId = 'SIM-' . strtoupper(bin2hex(random_bytes(8)));
        $pedido->wompi_transaction_id = $transactionId;
        $pedido->wompi_payment_method = 'SIMULATED';
        $pedido->wompi_status = 'APPROVED';
        $pedido->estado = 'pagado';
        $pedido->save();

        $this->descontarStock($pedido);
        $this->enviarNotificacionPedido($pedido);

        $transactionData = [
            'id' => $transactionId,
            'reference' => $pedido->wompi_reference,
            'status' => 'APPROVED',
            'payment_method_type' => 'SIMULATED',
            'amount_in_cents' => (int) ($pedido->total * 100),
            'created_at' => now()->toIso8601String(),
        ];

        return view('checkout.resultado', compact('pedido', 'transactionData'));
    }

    private function descontarStock(Pedido $pedido): void
    {
        $detalles = PedidoDetalle::where('pedido_id', $pedido->id)->get();

        foreach ($detalles as $detalle) {
            $producto = Producto::find($detalle->producto_id);
            if ($producto) {
                $producto->stock = max(0, $producto->stock - $detalle->cantidad);
                $producto->save();
            }
        }
    }

    private function enviarNotificacionPedido(Pedido $pedido): void
    {
        try {
            Mail::to($pedido->usuario->correo)->send(new OrderStatusMailable($pedido));
        } catch (\Exception $e) {
            Log::error("Error enviando email de pago pedido #{$pedido->id}: " . $e->getMessage());
        }
    }

    // Método para validar la firma digital de Wompi
    private function validateSignature(Request $request, string $eventSecret)
    {
        $payload = $request->all();
        $signature = $payload['signature'] ?? null;
        if (!$signature) {
            return false;
        }

        $properties = $signature['properties'] ?? [];
        $checksum = $signature['checksum'] ?? '';
        $timestamp = $payload['timestamp'] ?? '';

        $concatenated = '';
        foreach ($properties as $prop) {
            $value = data_get($payload, 'data.' . $prop);
            $concatenated .= $value;
        }
        $concatenated .= $timestamp;
        $concatenated .= $eventSecret;

        $calculatedHash = hash('sha256', $concatenated);

        return hash_equals($calculatedHash, $checksum);
    }
}
