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
}
