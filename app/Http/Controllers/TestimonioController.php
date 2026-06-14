<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonio;
use Illuminate\Support\Facades\Auth;

class TestimonioController extends Controller
{
    public function create()
    {
        return view('testimonios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'comentario' => 'required|string|max:500',
            'calificacion' => 'required|integer|min:1|max:5',
        ]);

        Testimonio::create([
            'usuario_id' => Auth::id(),
            'comentario' => $request->comentario,
            'calificacion' => $request->calificacion,
            'estado' => 1
        ]);

        return redirect()->route('cliente.dashboard')->with('success', '¡Gracias por dejarnos tu reseña! Ya está publicada en la página principal.');
    }

    public function storeProducto(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|string|max:500',
            'calificacion' => 'required|integer|min:1|max:5',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $nombreImagen = null;
        if ($request->hasFile('imagen')) {
            $nombreImagen = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('testimonios'), $nombreImagen);
        }

        Testimonio::create([
            'usuario_id' => Auth::id(),
            'producto_id' => $id,
            'comentario' => $request->comentario,
            'calificacion' => $request->calificacion,
            'imagen' => $nombreImagen,
            'estado' => 1
        ]);

        return redirect()->route('tienda.producto', $id)->with('success', '¡Gracias por dejarnos tu reseña sobre este producto!');
    }
}
