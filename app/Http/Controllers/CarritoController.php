<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    // Mostrar carrito
    public function index()
    {
        $carrito = session()->get('carrito', []);

        return view('carrito.index', compact('carrito'));
    }

    public function agregar(Request $request, int $id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->stock <= 0) {
            return $request->expectsJson()
                ? response()->json(['error' => 'Producto agotado'], 400)
                : back()->with('error', 'Producto agotado');
        }

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
                'carrito_count' => count(session()->get('carrito', [])),
            ]);
        }

        return back()->with('success', 'Producto agregado al carrito');
    }

    // Eliminar producto
    public function eliminar(int $id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }

        return back();
    }

    // Ir al checkout
    public function confirmar()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('tienda')->with('error', 'El carrito está vacío');
        }

        return redirect()->route('checkout.index');
    }
}
