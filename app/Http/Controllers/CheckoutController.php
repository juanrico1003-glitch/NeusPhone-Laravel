<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderAdminMailable;
use App\Models\Cupon;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public static function calcularCostoEnvio($departamento)
    {
        $departamento = strtolower(trim($departamento));
        $gratis = ['valle del cauca', 'cauca', 'quindio', 'risaralda', 'caldas'];
        $costoMedio = ['antioquia', 'cundinamarca', 'bogotá', 'bogota', 'tolima', 'huila', 'narino', 'putumayo'];
        if (in_array($departamento, $gratis)) return 0;
        if (in_array($departamento, $costoMedio)) return 15000;
        return 25000;
    }

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

        $costoEnvio = $ultimoEnvio ? self::calcularCostoEnvio($ultimoEnvio->departamento) : 0;
        return view('checkout.index', compact('carrito', 'usuario', 'ultimoEnvio', 'costoEnvio'));
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

        $descuento = 0;
        $cuponId = session('cupon_id');
        $cupon = null;
        if ($cuponId) {
            $cupon = Cupon::find($cuponId);
        }

        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }

        if ($cupon && $cupon->esValido() && (!$cupon->minimo_compra || $subtotal >= $cupon->minimo_compra)) {
            $descuento = $subtotal - $cupon->aplicarDescuento($subtotal);
        }

        $costoEnvio = self::calcularCostoEnvio($request->departamento);
        $total = ($subtotal - $descuento) + $costoEnvio;

        DB::beginTransaction();
        try {
            // Crear el pedido en estado pendiente
            $pedido = Pedido::create([
                'usuario_id' => Auth::id(),
                'total' => $total,
                'subtotal' => $subtotal,
                'descuento' => $descuento,
                'costo_envio' => $costoEnvio,
                'cupon_id' => $cupon?->id,
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

            if ($cupon) {
                $cupon->increment('usos_actuales');
            }

            DB::commit();

            try {
                $admins = \App\Models\Usuario::whereHas('rol', fn($q) => $q->where('nombre', 'admin'))->get();
                foreach ($admins as $admin) {
                    \Illuminate\Support\Facades\Mail::to($admin->correo)->queue(new NewOrderAdminMailable($pedido));
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Error notificando admin: ' . $e->getMessage());
            }

            // Vaciar el carrito de la sesión
            session()->forget('carrito');
            session()->forget('cupon_id');
            session()->forget('cupon_codigo');
            session()->forget('cupon_descuento');

            return redirect()->route('checkout.pagar', $pedido->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
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

    public function aplicarCupon(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50',
        ]);

        $cupon = Cupon::where('codigo', $request->codigo)->first();

        if (!$cupon || !$cupon->esValido()) {
            return back()->with('error', 'El cupón no es válido o ha expirado.');
        }

        $carrito = session()->get('carrito', []);
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }

        if ($cupon->minimo_compra && $subtotal < $cupon->minimo_compra) {
            return back()->with('error', 'El pedido mínimo para este cupón es $' . number_format($cupon->minimo_compra, 0, ',', '.'));
        }

        session(['cupon_id' => $cupon->id]);
        session(['cupon_codigo' => $cupon->codigo]);
        session(['cupon_descuento' => $subtotal - $cupon->aplicarDescuento($subtotal)]);

        return back()->with('success', 'Cupón aplicado correctamente. Descuento: $' . number_format(session('cupon_descuento'), 0, ',', '.'));
    }

    public function removerCupon()
    {
        session()->forget('cupon_id');
        session()->forget('cupon_codigo');
        session()->forget('cupon_descuento');

        return back()->with('success', 'Cupón removido.');
    }
}
