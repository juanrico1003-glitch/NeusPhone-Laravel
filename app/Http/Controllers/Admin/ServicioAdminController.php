<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SolicitudServicio;
use Illuminate\Http\Request;

class ServicioAdminController extends Controller
{
    // Listado de solicitudes
    public function index(Request $request)
    {
        $query = SolicitudServicio::with('usuario', 'servicio')
            ->orderBy('created_at', 'desc');

        // Filtro por estado
        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        $solicitudes = $query->get();

        return view('admin.servicios.index', compact('solicitudes'));
    }

    // Cambiar estado
    public function cambiarEstado(Request $request, int $id)
    {
        $solicitud = SolicitudServicio::findOrFail($id);

        $request->validate([
            'estado' => 'required'
        ]);

        $solicitud->estado = $request->estado;
        $solicitud->save();

        return back()->with('success', 'Estado actualizado');
    }
}
