<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'correo' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Usuario::where('correo', $request->correo)->first();

        if (!$user) {
            return back()->withInput($request->only('correo'))
                ->withErrors(['correo' => 'No encontramos un usuario con ese correo electrónico.']);
        }

        $broker = Password::broker();
        $repository = $broker->getRepository();

        if (!$repository->exists($user, $request->token)) {
            return back()->withInput($request->only('correo'))
                ->withErrors(['correo' => 'El enlace de restablecimiento no es válido o ha expirado.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        $repository->delete($user);

        return redirect()->route('login')->with('status', 'Tu contraseña ha sido restablecida exitosamente.');
    }
}
