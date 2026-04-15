<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Testimonio;

class AdminController extends Controller
{
    public function index()
    {
        // Productos
        $productosActivos = Producto::where('estado', 1)->count();
        $sinStock = Producto::where('stock', '<=', 0)->count();

        // Pedidos
        $pendientes = Pedido::where('estado', 'pendiente')->count();
        $serviciosPendientes = \App\Models\SolicitudServicio::where('estado', 'pendiente')->count();

        // Ventas totales (sin cancelados)
        $ventas = Pedido::where('estado', '!=', 'cancelado')->sum('total');

        return view('admin.dashboard', compact(
            'productosActivos',
            'sinStock',
            'pendientes',
            'ventas',
            'serviciosPendientes'
        ));
    }

    public function testimonios()
    {
        $testimonios = Testimonio::with('usuario')->orderBy('created_at', 'desc')->get();
        return view('admin.testimonios.index', compact('testimonios'));
    }

    public function toggleTestimonio($id)
    {
        $testimonio = Testimonio::findOrFail($id);
        $testimonio->estado = $testimonio->estado == 1 ? 0 : 1;
        $testimonio->save();

        return redirect()->back()->with('success', 'Estado del testimonio actualizado correctamente.');
    }
}
