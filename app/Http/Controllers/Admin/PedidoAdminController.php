<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusMailable;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PedidoAdminController extends Controller
{
    // Listado de todos los pedidos
    public function index(Request $request)
    {
        $query = Pedido::with('usuario')->orderBy('id', 'desc');

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        $pedidos = $query->paginate(20)->withQueryString();

        return view('admin.pedidos.index', compact('pedidos'));
    }

    // Ver detalle de pedido
    public function show($id)
    {
        $pedido = Pedido::findOrFail($id);

        $detalles = $pedido->detalles()->with('producto')->get();

        return view('admin.pedidos.show', compact('pedido', 'detalles'));
    }

    // Cambiar estado del pedido
public function cambiarEstado(Request $request, $id)
{
    $pedido = Pedido::findOrFail($id);
    $estadoAnterior = $pedido->estado;
    $nuevoEstado = $request->estado;

    $pedido->estado = $nuevoEstado;
    $pedido->save();

    // Restaurar stock si se cancela (solo si estaba pagado/enviado)
    if ($nuevoEstado === 'cancelado' && in_array($estadoAnterior, ['pagado', 'enviado'])) {
        $detalles = PedidoDetalle::where('pedido_id', $pedido->id)->get();
        foreach ($detalles as $detalle) {
            $producto = Producto::find($detalle->producto_id);
            if ($producto) {
                $producto->increment('stock', $detalle->cantidad);
            }
        }
    }

    // Enviar notificación por correo al cliente
    try {
        Mail::to($pedido->usuario->correo)->send(new OrderStatusMailable($pedido));
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error("Error enviando email de estado pedido #{$pedido->id}: " . $e->getMessage());
    }

    return back()->with('success', 'Estado actualizado');
}

public function actualizarGuia(Request $request, $id)
{
    $pedido = Pedido::findOrFail($id);
    $request->validate(['numero_guia' => 'nullable|string|max:100']);
    $pedido->envio->update(['numero_guia' => $request->numero_guia]);
    return back()->with('success', 'Número de guía actualizado.');
}
}
