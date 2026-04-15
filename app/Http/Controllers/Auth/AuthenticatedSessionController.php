<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    
     // Mostrar la vista de login
     
    public function create(): View
    {
        return view('auth.login');
    }

    
     // Manejar el intento de inicio de sesión
     
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    $usuario = auth()->user();

    // Si es admin
    if ($usuario->rol_id == 1) {
        return redirect()->route('admin.dashboard');
    }

    // Si es cliente
    return redirect()->route('tienda');
}
    
     // Cerrar sesión
     
    public function destroy(Request $request): RedirectResponse
    {
        // Cierra la sesión del usuario
        Auth::guard('web')->logout();

        // Invalida la sesión actual
        $request->session()->invalidate();

        // Regenera el token CSRF
        $request->session()->regenerateToken();

        // Redirige al inicio
        return redirect('/');
    }
}
