<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'cedula' => ['required', 'string', 'max:20', 'unique:usuarios,cedula'],
            'correo' => ['required', 'string', 'email', 'max:150', 'unique:usuarios,correo'],
            'fecha_nacimiento' => ['required', 'date'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $usuario = Usuario::create([
            'rol_id' => 2,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'cedula' => $request->cedula,
            'correo' => $request->correo,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'password' => Hash::make($request->password),
            'estado' => 1
        ]);

        Http::timeout(5)->post(env('N8N_WELCOME_WEBHOOK'), [
            'nombres' => $usuario->nombres,
            'apellidos' => $usuario->apellidos,
            'email' => $usuario->correo,
            'app' => 'NeusPhone',
        ]);

        Auth::login($usuario);

        return redirect()->route('tienda');
    }
}