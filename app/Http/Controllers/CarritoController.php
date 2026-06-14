<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $items = Carrito::with('producto')->where('usuario_id', Auth::id())->get();
            $carrito = [];
            foreach ($items as $item) {
                $carrito[$item->producto_id] = [
                    'nombre' => $item->producto->nombre,
                    'precio' => $item->producto->precio,
                    'imagen' => !empty($item->producto->imagenes) ? $item->producto->imagenes[0] : '',
                    'cantidad' => $item->cantidad,
                    'stock' => $item->producto->stock,
                ];
            }
        } else {
            $carrito = session()->get('carrito', []);
        }

        return view('carrito.index', compact('carrito') + ['metaTitle' => 'Carrito - NeusPhone']);
    }

    public function agregar(Request $request, int $id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->stock <= 0) {
            return $request->expectsJson()
                ? response()->json(['error' => 'Producto agotado'], 400)
                : back()->with('error', 'Producto agotado');
        }

        if (Auth::check()) {
            $item = Carrito::where('usuario_id', Auth::id())->where('producto_id', $id)->first();
            $cantidadActual = $item ? $item->cantidad : 0;

            if ($cantidadActual >= $producto->stock) {
                return $request->expectsJson()
                    ? response()->json(['error' => 'No hay más unidades disponibles'], 400)
                    : back()->with('error', 'No hay más unidades disponibles');
            }

            if ($item) {
                $item->increment('cantidad');
            } else {
                Carrito::create(['usuario_id' => Auth::id(), 'producto_id' => $id, 'cantidad' => 1]);
            }
        } else {
            $carrito = session()->get('carrito', []);
            $cantidadEnCarrito = isset($carrito[$id]) ? $carrito[$id]['cantidad'] : 0;

            if ($cantidadEnCarrito >= $producto->stock) {
                return $request->expectsJson()
                    ? response()->json(['error' => 'No hay más unidades disponibles'], 400)
                    : back()->with('error', 'No hay más unidades disponibles');
            }

            if (isset($carrito[$id])) {
                $carrito[$id]['cantidad']++;
            } else {
                $carrito[$id] = [
                    "nombre" => $producto->nombre,
                    "precio" => $producto->precio,
                    "imagen" => !empty($producto->imagenes) ? $producto->imagenes[0] : '',
                    "cantidad" => 1
                ];
            }
            session()->put('carrito', $carrito);
        }

        if ($request->expectsJson()) {
            $imagen = !empty($producto->imagenes) ? $producto->imagenes[0] : 'default.png';
            return response()->json([
                'success' => true,
                'producto' => [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precio,
                    'imagen_url' => asset('productos/' . $imagen),
                ],
                'carrito_count' => $this->getCarritoCount(),
            ]);
        }

        return back()->with('success', 'Producto agregado al carrito');
    }

    public function eliminar(int $id)
    {
        if (Auth::check()) {
            Carrito::where('usuario_id', Auth::id())->where('producto_id', $id)->delete();
        } else {
            $carrito = session()->get('carrito', []);
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }

        return back();
    }

    public function actualizar(Request $request, int $id)
    {
        $request->validate(['cantidad' => 'required|integer|min:1']);

        $producto = Producto::findOrFail($id);
        $cantidad = min($request->cantidad, $producto->stock);

        if (Auth::check()) {
            Carrito::updateOrCreate(
                ['usuario_id' => Auth::id(), 'producto_id' => $id],
                ['cantidad' => $cantidad]
            );
        } else {
            $carrito = session()->get('carrito', []);
            if (isset($carrito[$id])) {
                $carrito[$id]['cantidad'] = $cantidad;
                session()->put('carrito', $carrito);
            }
        }

        return back();
    }

    public function confirmar()
    {
        $count = $this->getCarritoCount();
        if ($count === 0) {
            return redirect()->route('tienda')->with('error', 'El carrito está vacío');
        }
        return redirect()->route('checkout.index');
    }

    private function getCarritoCount(): int
    {
        if (Auth::check()) {
            return Carrito::where('usuario_id', Auth::id())->sum('cantidad');
        }
        return array_sum(array_column(session()->get('carrito', []), 'cantidad'));
    }
}
