<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    // Mostrar productos activos al cliente
    public function index(Request $request)
    {
        $query = Producto::where('estado', 1);

        if ($request->buscar) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        if ($request->marca) {
            $query->where('marca_id', $request->marca);
        }

        if ($request->tipo) {
            $query->where('tipo', $request->tipo);
        }

        // Ordenar por precio
        if ($request->orden == 'asc') {
            $query->orderBy('precio', 'asc');
        }

        if ($request->orden == 'desc') {
            $query->orderBy('precio', 'desc');
        }

        $productos = $query->get();
        $marcas = \App\Models\Marca::all();

        return view('tienda.index', compact('productos', 'marcas'));
    }

    // Mostrar detalle del producto
    public function show(int $id)
    {
        $producto = \App\Models\Producto::with(['categoria', 'marca'])
            ->where('estado', 1)
            ->findOrFail($id);

        return view('tienda.show', compact('producto'));
    }
}
