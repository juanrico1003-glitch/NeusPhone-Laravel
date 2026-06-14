<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use App\Models\PedidoDetalle;
use App\Models\Producto;

class PedidoController extends Controller
{
    // Mostrar pedidos del usuario logueado
    public function index()
    {
        $pedidos = Pedido::where('usuario_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    // Mostrar detalle de un pedido
    public function show(int $id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $detalles = PedidoDetalle::where('pedido_id', $pedido->id)
            ->with('producto')
            ->get();

        return view('pedidos.show', compact('pedido', 'detalles'));
    }

    public function cancelar($id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('usuario_id', auth()->id())
            ->whereIn('estado', ['pendiente', 'pagado'])
            ->firstOrFail();

        $estadoAnterior = $pedido->estado;
        $pedido->estado = 'cancelado';
        $pedido->save();

        if (in_array($estadoAnterior, ['pagado'])) {
            $detalles = PedidoDetalle::where('pedido_id', $pedido->id)->get();
            foreach ($detalles as $detalle) {
                $producto = Producto::find($detalle->producto_id);
                if ($producto) {
                    $producto->increment('stock', $detalle->cantidad);
                }
            }
        }

        return redirect()->route('pedidos.show', $pedido->id)->with('success', 'Pedido cancelado correctamente.');
    }
}
