<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
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

    // Agregar producto
public function agregar($id)
{
    $producto = Producto::findOrFail($id);

    if($producto->stock <= 0) {
        return back()->with('error', 'Producto agotado');
    }

    $carrito = session()->get('carrito', []);

    // Cantidad actual en carrito
    $cantidadEnCarrito = isset($carrito[$id]) ? $carrito[$id]['cantidad'] : 0;

    // Si intenta superar el stock
    if($cantidadEnCarrito >= $producto->stock) {
        return back()->with('error', 'No hay más unidades disponibles');
    }

    if(isset($carrito[$id])) {
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

    return back()->with('success', 'Producto agregado al carrito');
}

    // Eliminar producto
    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);

        if(isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }

        return back();
    }

    // Confirmar compra y crear pedido
    public function confirmar()
    {
        $carrito = session()->get('carrito', []);

        if(empty($carrito)) {
            return back();
        }

        $total = 0;

        foreach($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // Crear pedido
        $pedido = Pedido::create([
            'usuario_id' => Auth::id(),
            'total' => $total,
            'estado' => 'pendiente'
        ]);

        // Guardar productos y descontar stock
        foreach($carrito as $id => $item) {

            PedidoDetalle::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $id,
                'cantidad' => $item['cantidad'],
                'precio' => $item['precio']
            ]);

            // Descontar inventario
            $producto = Producto::find($id);

            if($producto) {
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }
        }

        // Vaciar carrito
        session()->forget('carrito');

        return redirect()->route('tienda')
            ->with('success', 'Pedido realizado correctamente');
    }
}
