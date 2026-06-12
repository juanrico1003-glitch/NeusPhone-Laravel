<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::with('rol');

        if ($search = $request->buscar) {
            $query->where(function ($q) use ($search) {
                $q->where('nombres', 'like', "%{$search}%")
                  ->orWhere('apellidos', 'like', "%{$search}%")
                  ->orWhere('correo', 'like', "%{$search}%")
                  ->orWhere('cedula', 'like', "%{$search}%");
            });
        }

        $usuarios = $query->orderBy('created_at', 'desc')->paginate(20);

        $totalUsuarios = Usuario::count();
        $activos = Usuario::where('estado', 1)->count();
        $nuevosEsteMes = Usuario::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.usuarios.index', compact('usuarios', 'totalUsuarios', 'activos', 'nuevosEsteMes'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'cedula' => 'nullable|string|max:20|unique:usuarios,cedula',
            'correo' => 'nullable|email|max:150|unique:usuarios,correo',
            'password' => 'required|string|min:6|confirmed',
            'rol_id' => 'required|exists:roles,id',
            'estado' => 'required|in:0,1',
        ]);

        Usuario::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'cedula' => $request->cedula,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'estado' => $request->estado,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(Usuario $usuario)
    {
        $roles = Rol::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $rules = [
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'cedula' => 'nullable|string|max:20|unique:usuarios,cedula,' . $usuario->id,
            'correo' => 'nullable|email|max:150|unique:usuarios,correo,' . $usuario->id,
            'rol_id' => 'required|exists:roles,id',
            'estado' => 'required|in:0,1',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|confirmed';
        }

        $request->validate($rules);

        $data = $request->only(['nombres', 'apellidos', 'cedula', 'correo', 'rol_id', 'estado']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.usuarios.index')->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $usuario->update(['estado' => 0]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario desactivado correctamente.');
    }
}
