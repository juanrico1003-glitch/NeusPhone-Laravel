<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoAdminController extends Controller
{
    // Listado de todos los pedidos
    public function index()
    {
        $pedidos = Pedido::orderBy('id', 'desc')->get();

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

    $pedido->estado = $request->estado;
    $pedido->save();

    return back()->with('success', 'Estado actualizado');
}
}
