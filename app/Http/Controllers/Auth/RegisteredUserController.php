<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMailable;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        $rolId = \App\Models\Rol::where('nombre', 'cliente')->value('id') ?? 2;

        $usuario = Usuario::create([
            'rol_id' => $rolId,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'cedula' => $request->cedula,
            'correo' => $request->correo,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'password' => Hash::make($request->password),
            'estado' => 1
        ]);

        try {
            $webhookUrl = env('N8N_WELCOME_WEBHOOK');

            if ($webhookUrl) {
                Http::timeout(5)->post($webhookUrl, [
                    'nombres' => $usuario->nombres,
                    'apellidos' => $usuario->apellidos,
                    'email' => $usuario->correo,
                    'app' => 'NeusPhone',
                ]);
            } else {
                Log::warning('N8N_WELCOME_WEBHOOK no está configurado en .env');
            }
        } catch (\Exception $e) {
            Log::error('Error enviando webhook a n8n: ' . $e->getMessage());
        }

        // Enviar email de bienvenida
        try {
            Mail::to($usuario->correo)->send(new WelcomeMailable($usuario));
        } catch (\Exception $e) {
            Log::error('Error enviando email de bienvenida: ' . $e->getMessage());
        }

        Auth::login($usuario);

        return redirect()->route('tienda');
    }
}
