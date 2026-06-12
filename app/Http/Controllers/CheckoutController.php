<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Mostrar formulario de checkout
    public function index()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío');
        }

        $usuario = Auth::user();

        // Obtener el último envío del usuario para pre-llenar los campos
        $ultimoEnvio = \App\Models\Envio::whereHas('pedido', function ($query) {
            $query->where('usuario_id', Auth::id());
        })->latest()->first();

        return view('checkout.index', compact('carrito', 'usuario', 'ultimoEnvio'));
    }

    // Guardar el pedido y redireccionar a la página de pago
    public function store(Request $request)
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío');
        }

        // Validar datos de envío y facturación
        $request->validate([
            'nombre_contacto' => 'required|string|max:255',
            'correo_contacto' => 'required|email|max:255',
            'cedula_contacto' => 'required|string|max:50',
            'telefono_contacto' => 'required|string|max:50',
            'departamento' => 'required|string|max:100',
            'municipio' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'tipo_lugar' => 'required|string|in:casa,apartamento,oficina_empresa,edificio,otro',
            'nombre_lugar' => 'required_if:tipo_lugar,apartamento,oficina_empresa,edificio|nullable|string|max:255',
            'detalles_envio' => 'nullable|string|max:255',
        ]);

        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // Crear el pedido en estado pendiente
        $pedido = Pedido::create([
            'usuario_id' => Auth::id(),
            'total' => $total,
            'estado' => 'pendiente',
        ]);

        // Crear el envío asociado al pedido
        $pedido->envio()->create([
            'nombre_contacto' => $request->nombre_contacto,
            'correo_contacto' => $request->correo_contacto,
            'cedula_contacto' => $request->cedula_contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'departamento' => $request->departamento,
            'municipio' => $request->municipio,
            'direccion' => $request->direccion,
            'tipo_lugar' => $request->tipo_lugar,
            'nombre_lugar' => $request->nombre_lugar,
            'detalles_envio' => $request->detalles_envio,
        ]);

        // Guardar detalles del pedido (sin descontar stock aún, se descuenta cuando se confirme el pago)
        foreach ($carrito as $id => $item) {
            PedidoDetalle::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $id,
                'cantidad' => $item['cantidad'],
                'precio' => $item['precio']
            ]);
        }

        // Vaciar el carrito de la sesión
        session()->forget('carrito');

        return redirect()->route('checkout.pagar', $pedido->id);
    }

    public function pagar(int $id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->where('estado', 'pendiente')
            ->firstOrFail();

        $reference = 'NEUS-' . $pedido->id . '-' . time();
        $pedido->wompi_reference = $reference;
        $pedido->save();

        $amountInCents = (int) ($pedido->total * 100);
        $wompiPublicKey = env('WOMPI_PUBLIC_KEY');
        $wompiSimulated = env('WOMPI_SIMULATED', false) && env('WOMPI_MODE', 'sandbox') === 'sandbox';

        $wompiError = null;
        if (empty($wompiPublicKey)) {
            $wompiError = 'WOMPI_PUBLIC_KEY no está configurada en .env.';
        }

        $integritySecret = env('WOMPI_INTEGRITY_KEY');
        $signature = '';
        if (!empty($integritySecret)) {
            $signature = hash('sha256', $reference . $amountInCents . 'COP' . $integritySecret);
        }

        $redirectUrl = route('checkout.resultado');
        $baseUrl = 'https://checkout.wompi.co/p';
        $params = http_build_query([
            'reference' => $reference,
            'amount-in-cents' => $amountInCents,
            'currency' => 'COP',
            'redirect-url' => $redirectUrl,
        ]);
        $wompiCheckoutUrl = "{$baseUrl}/{$wompiPublicKey}?{$params}";
        if (!empty($signature)) {
            $wompiCheckoutUrl .= '&signature:integrity=' . urlencode($signature);
        }

        return view('checkout.pagar', compact(
            'pedido', 'reference', 'amountInCents',
            'wompiPublicKey', 'wompiCheckoutUrl', 'wompiError',
            'wompiSimulated', 'signature'
        ));
    }
}
