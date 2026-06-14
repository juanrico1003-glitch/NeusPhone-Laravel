<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            Log::error('Google callback error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Error al conectar con Google.');
        }

        $existing = Usuario::where('google_id', $googleUser->id)->first();
        if ($existing) {
            if ($existing->estaEliminado()) {
                if ($existing->puedeRecuperarse()) {
                    $existing->recuperar();
                } else {
                    return redirect()->route('login')->with('error', 'Tu cuenta fue eliminada permanentemente. No es posible iniciar sesión.');
                }
            }
            Auth::login($existing);
            return $this->redirectAfterLogin($existing);
        }

        $existingEmail = Usuario::where('correo', $googleUser->email)->first();
        if ($existingEmail) {
            if ($existingEmail->estaEliminado()) {
                if ($existingEmail->puedeRecuperarse()) {
                    $existingEmail->recuperar();
                } else {
                    return redirect()->route('login')->with('error', 'Tu cuenta fue eliminada permanentemente. No es posible iniciar sesión.');
                }
            }
            $existingEmail->update(['google_id' => $googleUser->id, 'avatar' => $googleUser->avatar]);
            Auth::login($existingEmail);
            return $this->redirectAfterLogin($existingEmail);
        }

        $nombres = $googleUser->user['given_name'] ?? explode(' ', $googleUser->name, 2)[0] ?? 'Usuario';
        $apellidos = $googleUser->user['family_name'] ?? (explode(' ', $googleUser->name, 2)[1] ?? '');

        $usuario = Usuario::create([
            'rol_id' => 2,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'correo' => $googleUser->email,
            'google_id' => $googleUser->id,
            'avatar' => $googleUser->avatar,
            'password' => null,
            'estado' => 1,
        ]);

        Auth::login($usuario);

        return $this->redirectAfterLogin($usuario);
    }

    private function redirectAfterLogin($usuario)
    {
        if ($usuario->rol_id == 1) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->intended(route('tienda'));
    }
}
