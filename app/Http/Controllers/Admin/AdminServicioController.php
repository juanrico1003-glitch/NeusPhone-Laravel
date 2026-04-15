<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SolicitudServicio;
use Illuminate\Http\Request;

class AdminServicioController extends Controller
{
    public function index()
    {
        $servicios = SolicitudServicio::with('usuario')->latest()->get();

        return view('admin.servicios.index', compact('servicios'));
    }

    public function estado(Request $request, $id)
    {
        $servicio = SolicitudServicio::findOrFail($id);
        $servicio->estado = $request->estado;
        $servicio->save();

        return back();
    }
}
