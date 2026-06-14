<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\SolicitudServicio;
use App\Models\Testimonio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $pedidos = Pedido::where('usuario_id', $user->id)->latest()->get();
        $servicios = SolicitudServicio::where('usuario_id', $user->id)->with('servicio')->latest()->get();
        $testimonios = Testimonio::where('usuario_id', $user->id)->with('producto')->latest()->get();

        return view('dashboard', compact('pedidos', 'servicios', 'testimonios'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'correo' => 'required|email|max:150|unique:usuarios,correo,' . $user->id,
            'cedula' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
        ];

        $messages = [
            'nombres.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.unique' => 'Este correo ya está registrado.',
        ];

        $request->validate($rules, $messages);

        $user->update($request->only(['nombres', 'apellidos', 'correo', 'cedula', 'telefono']));

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'nullable|current_password',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.current_password' => 'La contraseña actual no es correcta.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    public function requestDelete(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'delete_password' => 'required|current_password',
        ], [
            'delete_password.required' => 'Debes ingresar tu contraseña actual.',
            'delete_password.current_password' => 'La contraseña no es correcta.',
        ]);

        $user->update([
            'deleted_at' => now(),
            'deleted_scheduled_at' => now()->addDays(30),
        ]);

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Tu cuenta ha sido programada para eliminación. Tienes 30 días para recuperarla iniciando sesión nuevamente.');
    }

    public function cancelDelete()
    {
        $user = Auth::user();
        $user->recuperar();

        return back()->with('success', 'Tu solicitud de eliminación ha sido cancelada. Tu cuenta está activa nuevamente.');
    }
}
