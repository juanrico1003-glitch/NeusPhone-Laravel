<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\VarianteProducto;
use Illuminate\Http\Request;

class VarianteProductoController extends Controller
{
    public function index(Producto $producto)
    {
        $variantes = $producto->variantes()->orderBy('color')->orderBy('ram')->orderBy('almacenamiento')->get();
        $colores = \DB::table('colores')->pluck('nombre');
        $rams = \DB::table('rams')->pluck('nombre');
        $almacenamientos = \DB::table('almacenamientos')->pluck('nombre');
        return view('admin.productos.variantes', compact('producto', 'variantes', 'colores', 'rams', 'almacenamientos'));
    }

    public function store(Request $request, Producto $producto)
    {
        $request->validate([
            'color' => 'nullable|string|max:50',
            'ram' => 'nullable|string|max:50',
            'almacenamiento' => 'nullable|string|max:50',
            'sku' => 'nullable|string|max:100|unique:variantes_producto,sku',
            'precio_adicional' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $producto->variantes()->create($request->only('color', 'ram', 'almacenamiento', 'sku', 'precio_adicional', 'stock'));

        return redirect()->route('admin.productos.variantes', $producto->id)
            ->with('success', 'Variante creada correctamente.');
    }

    public function update(Request $request, Producto $producto, VarianteProducto $variante)
    {
        $request->validate([
            'color' => 'nullable|string|max:50',
            'ram' => 'nullable|string|max:50',
            'almacenamiento' => 'nullable|string|max:50',
            'sku' => 'nullable|string|max:100|unique:variantes_producto,sku,' . $variante->id,
            'precio_adicional' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $variante->update($request->only('color', 'ram', 'almacenamiento', 'sku', 'precio_adicional', 'stock'));

        return redirect()->route('admin.productos.variantes', $producto->id)
            ->with('success', 'Variante actualizada.');
    }

    public function destroy(Producto $producto, VarianteProducto $variante)
    {
        $variante->delete();
        return redirect()->route('admin.productos.variantes', $producto->id)
            ->with('success', 'Variante eliminada.');
    }
}
