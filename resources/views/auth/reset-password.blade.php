@extends('layouts.tienda')

@section('contenido')

<div class="flex justify-center items-center min-h-[70vh] px-4">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">

        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">
            Restablecer contraseña
        </h2>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Correo electrónico</label>
                <input type="email" name="correo" value="{{ old('correo', $request->correo) }}" readonly
                       class="w-full border rounded-lg px-3 py-2 bg-gray-50 text-gray-500 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required autofocus>
                @error('correo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Nueva contraseña</label>
                <input type="password" name="password"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required autocomplete="new-password">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Confirmar contraseña</label>
                <input type="password" name="password_confirmation"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required autocomplete="new-password">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition">
                Restablecer contraseña
            </button>
        </form>

    </div>

</div>

@endsection
