<?php

namespace App\Http\Controllers;

use App\Models\SolicitudServicio;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = SolicitudServicio::where('usuario_id', Auth::id())->latest()->get();

        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        $servicios = Servicio::where('estado', 1)->get();

        $user = Auth::user();

        return view('servicios.create', compact('servicios', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'descripcion_problema' => 'required|string|max:5000',
            'telefono' => 'required|string|max:20',
            'email_contacto' => 'nullable|email|max:150',
            'direccion' => 'nullable|string|max:500',
            'tipo_equipo' => 'required|string|max:100',
            'marca_equipo' => 'required|string|max:100',
            'modelo_equipo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'accesorios_incluidos' => 'nullable|string|max:2000',
        ]);

        SolicitudServicio::create([
            'usuario_id' => Auth::id(),
            'servicio_id' => $validated['servicio_id'],
            'descripcion_problema' => $validated['descripcion_problema'],
            'telefono' => $validated['telefono'],
            'email_contacto' => $validated['email_contacto'],
            'direccion' => $validated['direccion'],
            'tipo_equipo' => $validated['tipo_equipo'],
            'marca_equipo' => $validated['marca_equipo'],
            'modelo_equipo' => $validated['modelo_equipo'],
            'numero_serie' => $validated['numero_serie'],
            'accesorios_incluidos' => $validated['accesorios_incluidos'],
            'estado' => 'pendiente'
        ]);

        return redirect()->route('servicios.index')
            ->with('success', 'Solicitud enviada correctamente. Te contactaremos pronto.');
    }
}
