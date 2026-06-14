<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cupon;
use Illuminate\Http\Request;

class CuponAdminController extends Controller
{
    public function index()
    {
        $cupones = Cupon::orderBy('id', 'desc')->get();
        return view('admin.cupones.index', compact('cupones'));
    }

    public function create()
    {
        return view('admin.cupones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:cupones,codigo',
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:porcentaje,fijo',
            'valor' => 'required|numeric|min:0',
            'minimo_compra' => 'nullable|numeric|min:0',
            'usos_maximos' => 'nullable|integer|min:1',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        Cupon::create($request->all());

        return redirect()->route('admin.cupones.index')
            ->with('success', 'Cupón creado correctamente.');
    }

    public function edit(Cupon $cupone)
    {
        return view('admin.cupones.edit', compact('cupone'));
    }

    public function update(Request $request, Cupon $cupone)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:cupones,codigo,' . $cupone->id,
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:porcentaje,fijo',
            'valor' => 'required|numeric|min:0',
            'minimo_compra' => 'nullable|numeric|min:0',
            'usos_maximos' => 'nullable|integer|min:1',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $cupone->update($request->all());

        return redirect()->route('admin.cupones.index')
            ->with('success', 'Cupón actualizado correctamente.');
    }

    public function destroy(Cupon $cupone)
    {
        $cupone->delete();
        return redirect()->route('admin.cupones.index')
            ->with('success', 'Cupón eliminado.');
    }
}
