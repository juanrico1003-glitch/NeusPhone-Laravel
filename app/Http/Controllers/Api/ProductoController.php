<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with('categoria')->where('estado', 1);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', "%{$request->search}%")
                  ->orWhere('marca', 'like', "%{$request->search}%");
            });
        }
        if ($request->categoria_id) $query->where('categoria_id', $request->categoria_id);
        if ($request->marca) $query->where('marca', $request->marca);
        if ($request->min_precio) $query->where('precio', '>=', $request->min_precio);
        if ($request->max_precio) $query->where('precio', '<=', $request->max_precio);
        if ($request->tipo) $query->where('tipo', $request->tipo);

        $productos = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($productos);
    }

    public function show($id)
    {
        $producto = Producto::with(['categoria', 'testimonios' => function($q) {
            $q->where('estado', 1)->with('usuario');
        }])->where('estado', 1)->findOrFail($id);

        return response()->json($producto);
    }

    public function categorias()
    {
        return response()->json(Categoria::where('estado', 1)->orderBy('nombre')->get());
    }
}
