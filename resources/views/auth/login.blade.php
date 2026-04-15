@extends('layouts.tienda')

@section('contenido')

<div class="flex justify-center items-center min-h-[70vh]">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">

        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">
            Inicio de Sesión
        </h2>

        @if(session('error'))
            <div class="bg-red-500 text-white p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Correo electrónico</label>
                <input type="email" name="correo"
                       value="{{ old('correo') }}"
                       class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Contraseña</label>
                <input type="password" name="password"
                       class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">
                Ingresar
            </button>
        </form>

        <p class="text-center mt-4">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-blue-600 font-semibold">
                Regístrate
            </a>
        </p>

    </div>

</div>

@endsection
