<?php

namespace App\Http\Controllers;

use App\Models\SolicitudServicio;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    // Mostrar historial del usuario
    public function index()
    {
        $servicios = SolicitudServicio::where('usuario_id', Auth::id())->latest()->get();

        return view('servicios.index', compact('servicios'));
    }

    // Mostrar formulario
    public function create()
    {
        $servicios = Servicio::where('estado', 1)->get();

        return view('servicios.create', compact('servicios'));
    }

    // Guardar solicitud
    public function store(Request $request)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'descripcion_problema' => 'required|string'
        ]);

        SolicitudServicio::create([
            'usuario_id' => Auth::id(),
            'servicio_id' => $request->servicio_id,
            'descripcion_problema' => $request->descripcion_problema,
            'estado' => 'pendiente'
        ]);

        return redirect()->route('servicios.index')
            ->with('success', 'Solicitud enviada correctamente');
    }
}
