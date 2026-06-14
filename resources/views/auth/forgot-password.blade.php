@extends('layouts.tienda')

@section('contenido')

<div class="flex justify-center items-center min-h-[70vh] px-4">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">

        <h2 class="text-2xl font-bold text-center text-blue-600 mb-4">
            Recuperar contraseña
        </h2>

        <p class="text-sm text-gray-500 text-center mb-6">
            Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
        </p>

        @if(session('status'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-3 rounded-lg text-sm mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Correo electrónico</label>
                <input type="email" name="correo" value="{{ old('correo') }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required autofocus>
                @error('correo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition">
                Enviar enlace
            </button>
        </form>

        <p class="text-center mt-4 text-sm">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                ← Volver al inicio de sesión
            </a>
        </p>

    </div>

</div>

@endsection
