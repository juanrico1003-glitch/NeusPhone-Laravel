<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductStockSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $query->where('marca', $request->marca);
        }

        if ($request->tipo) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->oferta == '1') {
            $query->where('descuento', '>', 0)->where('stock', '>', 0);
        }

        // Ordenar por precio
        if ($request->orden == 'asc') {
            $query->orderBy('precio', 'asc');
        }

        if ($request->orden == 'desc') {
            $query->orderBy('precio', 'desc');
        }

        $productos = $query->paginate(12);
        $marcas = collect(\Database\Seeders\ProductoOpcionesSeeder::marcas())->flatten()->unique()->sort()->values()->all();
        $categorias = \App\Models\Categoria::where('estado', 1)->orderBy('nombre')->get();

        return view('tienda.index', compact('productos', 'marcas', 'categorias'));
    }

    // Mostrar detalle del producto
    public function show(int $id)
    {
        Producto::where('id', $id)->where('estado', 1)->increment('visitas');

        $producto = \App\Models\Producto::with(['categoria', 'testimonios' => function($q) {
            $q->where('estado', 1)->with('usuario');
        }])
            ->where('estado', 1)
            ->findOrFail($id);

        $productosFamilia = \App\Models\Producto::where('nombre', $producto->nombre)
            ->where('estado', 1)
            ->get();

        $coloresDisponibles = [];
        $colors = $productosFamilia->pluck('color')->filter()->unique();
        foreach ($colors as $color) {
            $match = $productosFamilia->where('color', $color)->where('almacenamiento', $producto->almacenamiento)->where('ram', $producto->ram)->first();
            if (!$match) {
                $match = $productosFamilia->where('color', $color)->first();
            }
            if ($match) {
                $stockTotal = $productosFamilia->where('color', $color)->sum('stock');
                $coloresDisponibles[] = [
                    'color' => $color,
                    'producto_id' => $match->id,
                    'has_stock' => $stockTotal > 0,
                    'is_active' => $color === $producto->color
                ];
            }
        }

        $ramsDisponibles = [];
        $rams = $productosFamilia->pluck('ram')->filter()->unique();
        foreach ($rams as $ram) {
            $match = $productosFamilia->where('ram', $ram)->where('color', $producto->color)->where('almacenamiento', $producto->almacenamiento)->first();
            if (!$match) {
                $match = $productosFamilia->where('ram', $ram)->first();
            }
            if ($match) {
                $stockTotal = $productosFamilia->where('ram', $ram)->sum('stock');
                $ramsDisponibles[] = [
                    'ram' => $ram,
                    'producto_id' => $match->id,
                    'has_stock' => $stockTotal > 0,
                    'is_active' => $ram === $producto->ram
                ];
            }
        }

        $almacenamientosDisponibles = [];
        $almacenamientos = $productosFamilia->pluck('almacenamiento')->filter()->unique();
        foreach ($almacenamientos as $alm) {
            $match = $productosFamilia->where('almacenamiento', $alm)->where('color', $producto->color)->where('ram', $producto->ram)->first();
            if (!$match) {
                $match = $productosFamilia->where('almacenamiento', $alm)->first();
            }
            if ($match) {
                $stockTotal = $productosFamilia->where('almacenamiento', $alm)->sum('stock');
                $almacenamientosDisponibles[] = [
                    'almacenamiento' => $alm,
                    'producto_id' => $match->id,
                    'has_stock' => $stockTotal > 0,
                    'is_active' => $alm === $producto->almacenamiento
                ];
            }
        }

        $recomendados = \App\Models\Producto::where('estado', 1)
            ->where('stock', '>', 0)
            ->where('id', '!=', $producto->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $yaSuscrito = false;
        if ($user = Auth::user()) {
            $yaSuscrito = ProductStockSubscription::where('producto_id', $producto->id)
                ->where('email', $user->correo)
                ->whereNull('notified_at')
                ->exists();
        }

        return view('tienda.show', compact('producto', 'coloresDisponibles', 'almacenamientosDisponibles', 'ramsDisponibles', 'recomendados', 'yaSuscrito'));
    }

    public function suscribirStock(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $email = Auth::check() ? Auth::user()->correo : $request->email;

        if (!$email) {
            return back()->with('error', 'Debes iniciar sesión o proporcionar un correo.');
        }

        $existing = ProductStockSubscription::where('producto_id', $id)
            ->where('email', $email)
            ->whereNull('notified_at')
            ->first();

        if ($existing) {
            return back()->with('info', 'Ya estás suscrito para recibir notificaciones de este producto.');
        }

        ProductStockSubscription::create([
            'producto_id' => $id,
            'usuario_id' => Auth::id(),
            'email' => $email,
        ]);

        return back()->with('success', 'Te avisaremos cuando este producto vuelva a estar disponible.');
    }
}
