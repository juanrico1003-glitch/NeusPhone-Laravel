<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;

class ProductoController extends Controller
{
    // Mostrar listado de productos
    public function index()
    {
        // Traemos productos con relaciones
        $productos = Producto::with(['categoria'])->get();

        return view('admin.productos.index', compact('productos'));
    }

    // Mostrar formulario para crear producto

    public function create()
    {
        // Traemos datos para los selects
        $categorias = Categoria::where('estado', 1)->get();
        $marcas = \Database\Seeders\ProductoOpcionesSeeder::marcas();
        $colores = \Database\Seeders\ProductoOpcionesSeeder::colores();
        $almacenamientos = \Database\Seeders\ProductoOpcionesSeeder::almacenamientos();
        $rams = \Database\Seeders\ProductoOpcionesSeeder::rams();

        return view('admin.productos.create', compact(
            'categorias',
            'marcas',
            'colores',
            'almacenamientos',
            'rams'
        ));
    }
    // Guardar nuevo producto en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required',
            'marca' => 'required',
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
        ]);
        // Procesar imagenes
        $nombresImagenes = [];

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('productos'), $nombreImagen);
                $nombresImagenes[] = $nombreImagen;
            }
        }
        Producto::create([
            'categoria_id' => $request->categoria_id,
            'marca' => $request->marca,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'color' => $request->color,
            'ram' => $request->ram,
            'almacenamiento' => $request->almacenamiento,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'descripcion' => $request->descripcion,
            'caracteristicas' => $request->caracteristicas,
            'imagenes' => empty($nombresImagenes) ? null : $nombresImagenes,
            'estado' => 1
        ]);

        return redirect()->route('admin.productos.index');
    }
    // Mostrar un producto específico
    public function show(string $id)
    {
        // Detalle del producto
    }
    // Mostrar formulario de edicion
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);

        $categorias = Categoria::where('estado', 1)->get();
        $marcas = \Database\Seeders\ProductoOpcionesSeeder::marcas();
        $colores = \Database\Seeders\ProductoOpcionesSeeder::colores();
        $almacenamientos = \Database\Seeders\ProductoOpcionesSeeder::almacenamientos();
        $rams = \Database\Seeders\ProductoOpcionesSeeder::rams();

        return view('admin.productos.edit', compact(
            'producto',
            'categorias',
            'marcas',
            'colores',
            'almacenamientos',
            'rams'
        ));
    }

    // Actualizar producto
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        $producto->categoria_id = $request->categoria_id;
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->marca = $request->marca;
        $producto->color = $request->color;
        $producto->ram = $request->ram;
        $producto->almacenamiento = $request->almacenamiento;
        $producto->descripcion = $request->descripcion;
        $producto->caracteristicas = $request->caracteristicas;

        if ($request->hasFile('imagenes')) {
            $nombresImagenes = [];
            foreach ($request->file('imagenes') as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
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

    // Cambiar estado
    public function toggleEstado(int $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = $producto->estado == 1 ? 0 : 1;
        $producto->save();
        return redirect()->route('admin.productos.index');
    }
}
