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
        $producto = \App\Models\Producto::with(['categoria', 'marca', 'color', 'almacenamiento', 'ram'])
            ->where('estado', 1)
            ->findOrFail($id);

        $productosFamilia = \App\Models\Producto::with(['color', 'almacenamiento', 'ram'])
            ->where('nombre', $producto->nombre)
            ->where('estado', 1)
            ->get();

        $coloresDisponibles = [];
        $colors = $productosFamilia->pluck('color')->filter()->unique('id');
        foreach ($colors as $color) {
            $match = $productosFamilia->where('color_id', $color->id)->where('almacenamiento_id', $producto->almacenamiento_id)->where('ram_id', $producto->ram_id)->first();
            if (!$match) {
                $match = $productosFamilia->where('color_id', $color->id)->first();
            }
            if ($match) {
                $stockTotal = $productosFamilia->where('color_id', $color->id)->sum('stock');
                $coloresDisponibles[] = [
                    'color' => $color,
                    'producto_id' => $match->id,
                    'has_stock' => $stockTotal > 0,
                    'is_active' => $color->id === $producto->color_id
                ];
            }
        }

        $ramsDisponibles = [];
        $rams = $productosFamilia->pluck('ram')->filter()->unique('id');
        foreach ($rams as $ram) {
            $match = $productosFamilia->where('ram_id', $ram->id)->where('color_id', $producto->color_id)->where('almacenamiento_id', $producto->almacenamiento_id)->first();
            if (!$match) {
                $match = $productosFamilia->where('ram_id', $ram->id)->first();
            }
            if ($match) {
                $stockTotal = $productosFamilia->where('ram_id', $ram->id)->sum('stock');
                $ramsDisponibles[] = [
                    'ram' => $ram,
                    'producto_id' => $match->id,
                    'has_stock' => $stockTotal > 0,
                    'is_active' => $ram->id === $producto->ram_id
                ];
            }
        }

        $almacenamientosDisponibles = [];
        $almacenamientos = $productosFamilia->pluck('almacenamiento')->filter()->unique('id');
        foreach ($almacenamientos as $alm) {
            $match = $productosFamilia->where('almacenamiento_id', $alm->id)->where('color_id', $producto->color_id)->where('ram_id', $producto->ram_id)->first();
            if (!$match) {
                $match = $productosFamilia->where('almacenamiento_id', $alm->id)->first();
            }
            if ($match) {
                $stockTotal = $productosFamilia->where('almacenamiento_id', $alm->id)->sum('stock');
                $almacenamientosDisponibles[] = [
                    'almacenamiento' => $alm,
                    'producto_id' => $match->id,
                    'has_stock' => $stockTotal > 0,
                    'is_active' => $alm->id === $producto->almacenamiento_id
                ];
            }
        }

        return view('tienda.show', compact('producto', 'coloresDisponibles', 'almacenamientosDisponibles', 'ramsDisponibles'));
    }
}
