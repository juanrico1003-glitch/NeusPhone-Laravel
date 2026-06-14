<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\ProductImage;
use App\Models\ProductStockSubscription;
use App\Mail\StockBackMailable;
use Database\Seeders\ProductoOpcionesSeeder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with(['categoria']);

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('marca', 'like', "%{$search}%");
            });
        }

        if ($request->categoria_id) {
            $query->where('categoria_id', $request->categoria_id);
        }

        $productos = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $categorias = Categoria::where('estado', 1)->orderBy('nombre')->get();

        return view('admin.productos.index', compact('productos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::where('estado', 1)->get();
        $colores = DB::table('colores')->pluck('nombre');

        $marcasPorCategoria = $this->opcionesPorCategoria($categorias, 'marcas', ProductoOpcionesSeeder::marcas());
        $ramsPorCategoria = $this->opcionesPorCategoria($categorias, 'rams', ProductoOpcionesSeeder::rams());
        $almacenamientosPorCategoria = $this->opcionesPorCategoria($categorias, 'almacenamientos', ProductoOpcionesSeeder::almacenamientos());
        $fieldConfigs = $this->opcionesPorCategoria($categorias, 'category_field_configs', ProductoOpcionesSeeder::fieldConfigs(), 'campo');

        return view('admin.productos.create', compact(
            'categorias', 'colores',
            'marcasPorCategoria', 'ramsPorCategoria',
            'almacenamientosPorCategoria', 'fieldConfigs'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'marca' => 'required|string|max:100',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

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
            'procesador' => $request->procesador,
            'tarjeta_grafica' => $request->tarjeta_grafica,
            'precio' => $request->precio,
            'descuento' => $request->descuento ?? 0,
            'stock' => $request->stock,
            'descripcion' => $request->descripcion,
            'caracteristicas' => $request->caracteristicas,
            'imagenes' => empty($nombresImagenes) ? null : $nombresImagenes,
            'estado' => 1
        ]);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function show(string $id)
    {
        $producto = Producto::with(['categoria'])->findOrFail($id);
        return view('admin.productos.show', compact('producto'));
    }

    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::where('estado', 1)->get();
        $colores = DB::table('colores')->pluck('nombre');

        $marcasPorCategoria = $this->opcionesPorCategoria($categorias, 'marcas', ProductoOpcionesSeeder::marcas());
        $ramsPorCategoria = $this->opcionesPorCategoria($categorias, 'rams', ProductoOpcionesSeeder::rams());
        $almacenamientosPorCategoria = $this->opcionesPorCategoria($categorias, 'almacenamientos', ProductoOpcionesSeeder::almacenamientos());
        $fieldConfigs = $this->opcionesPorCategoria($categorias, 'category_field_configs', ProductoOpcionesSeeder::fieldConfigs(), 'campo');

        return view('admin.productos.edit', compact(
            'producto', 'categorias', 'colores',
            'marcasPorCategoria', 'ramsPorCategoria',
            'almacenamientosPorCategoria', 'fieldConfigs'
        ));
    }

    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'marca' => 'required|string|max:100',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $producto->categoria_id = $request->categoria_id;
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->descuento = $request->descuento ?? 0;
        $producto->stock = $request->stock;
        $producto->marca = $request->marca;
        $producto->tipo = $request->tipo;
        $producto->color = $request->color;
        $producto->ram = $request->ram;
        $producto->almacenamiento = $request->almacenamiento;
        $producto->procesador = $request->procesador;
        $producto->tarjeta_grafica = $request->tarjeta_grafica;
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

        $oldStock = $producto->getOriginal('stock');
        $producto->save();

        if ($oldStock <= 0 && $producto->stock > 0) {
            $subscriptions = ProductStockSubscription::where('producto_id', $id)
                ->whereNull('notified_at')
                ->get();
            foreach ($subscriptions as $sub) {
                Mail::to($sub->email)->queue(new StockBackMailable($producto, $sub->email));
                $sub->update(['notified_at' => now()]);
            }
        }

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado');
    }

    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado');
    }

    public function subirImagen(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $path = $request->file('imagen')->store('productos', 'public');
        $nombre = basename($path);

        ProductImage::create([
            'producto_id' => $producto->id,
            'ruta' => $nombre,
            'orden' => $producto->fotos()->count(),
        ]);

        return back()->with('success', 'Imagen subida correctamente.');
    }

    public function eliminarImagen($id)
    {
        $imagen = ProductImage::findOrFail($id);
        Storage::disk('public')->delete('productos/' . $imagen->ruta);
        $imagen->delete();

        return back()->with('success', 'Imagen eliminada.');
    }

    public function toggleEstado(int $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = $producto->estado == 1 ? 0 : 1;
        $producto->save();
        return redirect()->route('admin.productos.index');
    }

    private function opcionesPorCategoria($categorias, string $tabla, array $fallback, string $columna = 'nombre')
    {
        $opciones = DB::table($tabla)->get()
            ->groupBy('categoria_id')
            ->map(fn($items) => $items->pluck($columna)->filter()->unique()->values()->all())
            ->all();

        foreach ($categorias as $categoria) {
            if (empty($opciones[$categoria->id]) && isset($fallback[$categoria->nombre])) {
                $opciones[$categoria->id] = collect($fallback[$categoria->nombre])->unique()->values()->all();
            }
        }

        return $opciones;
    }
}
