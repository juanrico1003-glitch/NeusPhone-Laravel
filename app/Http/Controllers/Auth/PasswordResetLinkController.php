<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'correo' => ['required', 'email'],
        ]);

        $user = Usuario::where('correo', $request->correo)->first();

        if (!$user) {
            return back()->withInput($request->only('correo'))
                ->withErrors(['correo' => 'No encontramos un usuario con ese correo electrónico.']);
        }

        $token = Password::broker()->getRepository()->create($user);
        $user->sendPasswordResetNotification($token);

        return back()->with('status', 'Te hemos enviado un enlace para restablecer tu contraseña.');
    }
}
