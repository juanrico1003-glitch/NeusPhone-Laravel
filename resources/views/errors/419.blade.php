@extends('layouts.tienda')

@section('contenido')

<div class="flex flex-col items-center justify-center min-h-[60vh] px-4 text-center">
    <div class="text-8xl font-bold text-yellow-200 mb-4">419</div>
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Sesión expirada</h1>
    <p class="text-gray-500 mb-6 max-w-md">Tu sesión ha expirado. Por favor, vuelve a intentarlo.</p>
    <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
        Volver e intentar de nuevo
    </a>
</div>

@endsection
