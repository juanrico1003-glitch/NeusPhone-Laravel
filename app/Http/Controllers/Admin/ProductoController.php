<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Color;
use App\Models\Almacenamiento;
use App\Models\Producto;

class ProductoController extends Controller
{
     // Mostrar listado de productos
    public function index()
{
    // Traemos productos con relaciones
    $productos = Producto::with(['categoria', 'marca', 'color', 'almacenamiento'])->get();

    return view('admin.productos.index', compact('productos'));
}
    
     // Mostrar formulario para crear producto
     
    public function create()
{
    // Traemos datos para los selects
    $categorias = Categoria::where('estado', 1)->get();
    $marcas = Marca::where('estado', 1)->get();
    $colores = Color::all();
    $almacenamientos = Almacenamiento::all();

    return view('admin.productos.create', compact(
        'categorias',
        'marcas',
        'colores',
        'almacenamientos'
    ));
}
     // Guardar nuevo producto en la base de datos
     
public function store(Request $request)
{
    $request->validate([
        'categoria_id' => 'required',
        'marca_id' => 'required',
        'nombre' => 'required',
        'precio' => 'required|numeric',
        'stock' => 'required|integer',
    ]);

    // Procesar imagenes
    $nombresImagenes = [];

    if ($request->hasFile('imagenes')) {
        foreach ($request->file('imagenes') as $imagen) {
            $nombreImagen = time().'_'.$imagen->getClientOriginalName();
            $imagen->move(public_path('productos'), $nombreImagen);
            $nombresImagenes[] = $nombreImagen;
        }
    }

    Producto::create([
        'categoria_id' => $request->categoria_id,
        'marca_id' => $request->marca_id,
        'nombre' => $request->nombre,
        'tipo' => $request->tipo,
        'color_id' => $request->color_id,
        'almacenamiento_id' => $request->almacenamiento_id,
        'precio' => $request->precio,
        'stock' => $request->stock,
        'descripcion' => $request->descripcion,
        'imagenes' => empty($nombresImagenes) ? null : $nombresImagenes,
        'estado' => 1
    ]);

    return redirect()->route('admin.productos.index');
}

     // Mostrar un producto específico
     
    public function show(string $id)
    {
        // Se usa cuando quieras ver detalle del producto
    }
     
    // Mostrar formulario de edición
public function edit(string $id)
{
    $producto = Producto::findOrFail($id);

    $categorias = Categoria::where('estado', 1)->get();
    $marcas = Marca::where('estado', 1)->get();
    $colores = Color::all();
    $almacenamientos = Almacenamiento::all();

    return view('admin.productos.edit', compact(
        'producto',
        'categorias',
        'marcas',
        'colores',
        'almacenamientos'
    ));
}
     
    // Actualizar producto
public function update(Request $request, string $id)
{
    $producto = Producto::findOrFail($id);

    $producto->nombre = $request->nombre;
    $producto->precio = $request->precio;
    $producto->stock = $request->stock;

    if ($request->hasFile('imagenes')) {
        $nombresImagenes = [];
        foreach ($request->file('imagenes') as $imagen) {
            $nombreImagen = time().'_'.$imagen->getClientOriginalName();
            $imagen->move(public_path('productos'), $nombreImagen);
            $nombresImagenes[] = $nombreImagen;
        }
        $producto->imagenes = $nombresImagenes;
    }

    $producto->save();

    return redirect()->route('admin.productos.index')
        ->with('success', 'Producto actualizado');
}

    // Eliminar producto
public function destroy(string $id)
{
    $producto = Producto::findOrFail($id);
    $producto->delete();

    return redirect()->route('admin.productos.index')
        ->with('success', 'Producto eliminado');
}

// Cambiar estado activo/inactivo
public function toggleEstado($id)
{
    $producto = Producto::findOrFail($id);

    // Si está activo lo apagamos, si está apagado lo activamos
    $producto->estado = $producto->estado == 1 ? 0 : 1;

    $producto->save();

    return redirect()->route('admin.productos.index');
}
}
