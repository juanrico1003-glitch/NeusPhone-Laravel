@extends('layouts.tienda')

@section('contenido')

<div class="flex justify-center items-center min-h-[80vh]">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-2xl">

        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">
            Registro de Usuario
        </h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label>Nombres</label>
                    <input type="text" name="nombres"
                           value="{{ old('nombres') }}"
                           class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div>
                    <label>Apellidos</label>
                    <input type="text" name="apellidos"
                           value="{{ old('apellidos') }}"
                           class="w-full border rounded-lg px-3 py-2" required>
                </div>

            </div>

            <div class="mt-4">
                <label>Cédula</label>
                <input type="text" name="cedula"
                       value="{{ old('cedula') }}"
                       class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">

                <div>
                    <label>Correo electrónico</label>
                    <input type="email" name="correo"
                           value="{{ old('correo') }}"
                           class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div>
                    <label>Confirmar correo</label>
                    <input type="email" name="correo_confirmation"
                           class="w-full border rounded-lg px-3 py-2" required>
                </div>

            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">

                <div>
                    <label>Contraseña</label>
                    <input type="password" name="password"
                           class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div>
                    <label>Confirmar contraseña</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border rounded-lg px-3 py-2" required>
                </div>

            </div>

            <div class="mt-4">
                <label>Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento"
                       value="{{ old('fecha_nacimiento') }}"
                       class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <button class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">
                Registrarse
            </button>

            <p class="text-center mt-4">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold">
                    Inicia sesión
                </a>
            </p>

        </form>

    </div>

</div>

@endsection
