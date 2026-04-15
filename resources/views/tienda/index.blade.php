@extends('layouts.tienda')

@section('contenido')

<h2 class="text-2xl font-bold mb-4">
    Productos disponibles
</h2>

<!-- Filtros debajo del título -->
<form method="GET" action="{{ route('tienda') }}" class="mb-8 flex gap-3">
    <!-- Marca -->
    <select name="marca"
    class="border border-gray-300 rounded-lg px-4 py-2 pr-10 bg-white appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <option value="">Todas las marcas</option>
        @foreach($marcas as $marca)
            <option value="{{ $marca->id }}"
                {{ request('marca') == $marca->id ? 'selected' : '' }}>
                {{ $marca->nombre }}
            </option>
        @endforeach
    </select>

    <!-- Condición -->
    <select name="tipo"
    class="border border-gray-300 rounded-lg px-4 py-2 pr-10 bg-white appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <option value="">Todos</option>
        <option value="nuevo" {{ request('tipo') == 'nuevo' ? 'selected' : '' }}>
            Nuevo
        </option>
        <option value="usado" {{ request('tipo') == 'usado' ? 'selected' : '' }}>
            Usado
        </option>
    </select>

    <!-- Orden -->
    <select name="orden"
        class="border border-gray-300 rounded-lg px-4 py-2 pr-10 bg-white appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <option value="">Ordenar por</option>
        <option value="asc" {{ request('orden') == 'asc' ? 'selected' : '' }}>
            Menor precio
        </option>
        <option value="desc" {{ request('orden') == 'desc' ? 'selected' : '' }}>
            Mayor precio
        </option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Filtrar
    </button>

</form>

<!-- Productos -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

    @forelse($productos as $producto)
        <div class="bg-white rounded-xl shadow hover:shadow-xl transition p-4">

            <a href="{{ route('tienda.show', $producto->id) }}">
                <img src="{{ asset('productos/'.(!empty($producto->imagenes) ? $producto->imagenes[0] : 'default.png')) }}"
                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
            </a>

            <h3 class="mt-3 font-semibold">
                {{ $producto->nombre }}
            </h3>

            <p class="text-green-600 text-xl font-bold mt-2">
                ${{ number_format($producto->precio, 0, ',', '.') }}
            </p>

            <a href="{{ route('tienda.producto', $producto->id) }}"
               class="mt-3 block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                Ver producto
            </a>
        </div>
    @empty
        <p>No hay productos disponibles</p>
    @endforelse

</div>

@endsection
