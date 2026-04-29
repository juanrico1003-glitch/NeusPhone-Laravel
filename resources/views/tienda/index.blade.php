@extends('layouts.tienda')

@section('contenido')

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800">
        Productos disponibles
    </h2>
    <p class="text-sm text-gray-500">{{ count($productos) }} productos encontrados</p>
</div>

<!-- Filtros -->
<form method="GET" action="{{ route('tienda') }}" class="mb-8 bg-white p-4 md:p-6 rounded-lg shadow-sm border border-gray-200">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
        <!-- Marca -->
        <div class="flex flex-col">
            <label class="text-sm font-semibold text-gray-700 mb-2">Marca</label>
            <select name="marca"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 md:px-4 md:py-2 pr-10 bg-white appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                <option value="">Todas las marcas</option>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->id }}"
                        {{ request('marca') == $marca->id ? 'selected' : '' }}>
                        {{ $marca->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Condicion -->
        <div class="flex flex-col">
            <label class="text-sm font-semibold text-gray-700 mb-2">Condición</label>
            <select name="tipo"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 md:px-4 md:py-2 pr-10 bg-white appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                <option value="">Todas</option>
                <option value="nuevo" {{ request('tipo') == 'nuevo' ? 'selected' : '' }}>
                    Nuevo
                </option>
                <option value="usado" {{ request('tipo') == 'usado' ? 'selected' : '' }}>
                    Usado
                </option>
            </select>
        </div>

        <!-- Orden -->
        <div class="flex flex-col">
            <label class="text-sm font-semibold text-gray-700 mb-2">Ordenar por</label>
            <select name="orden"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 md:px-4 md:py-2 pr-10 bg-white appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition">
                <option value="">Seleccionar</option>
                <option value="asc" {{ request('orden') == 'asc' ? 'selected' : '' }}>
                    Menor precio
                </option>
                <option value="desc" {{ request('orden') == 'desc' ? 'selected' : '' }}>
                    Mayor precio
                </option>
            </select>
        </div>

        <!-- Boton Filtrar -->
        <div class="flex items-end">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 md:py-2.5 rounded-lg transition transform hover:scale-105 active:scale-95">
                🔍 Filtrar
            </button>
        </div>
    </div>
</form>

<!-- Productos -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8">

    @forelse($productos as $producto)
        <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full">
            
            <!-- Imagen -->
            <div class="relative overflow-hidden bg-gray-100 aspect-square">
                <a href="{{ route('tienda.producto', $producto->id) }}" class="block h-full">
                    <img src="{{ asset('productos/'.(!empty($producto->imagenes) ? $producto->imagenes[0] : 'default.png')) }}"
                         alt="{{ $producto->nombre }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </a>
                
                <!-- Condicion -->
                <div class="absolute top-3 right-3">
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-600 text-white">
                        {{ $producto->tipo === 'nuevo' ? 'Nuevo' : 'Usado' }}
                    </span>
                </div>
            </div>

            <!-- Contenido -->
            <div class="flex-1 p-4 flex flex-col">
                <h3 class="text-sm md:text-base font-semibold text-gray-800 line-clamp-2 mb-2 group-hover:text-blue-600 transition">
                    {{ $producto->nombre }}
                </h3>

                <p class="text-xs text-gray-500 mb-1">
                    {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                </p>

                <p class="text-lg md:text-xl font-bold text-green-600 my-2">
                    ${{ number_format($producto->precio, 0, ',', '.') }}
                </p>

                <!-- Indicator -->
                <div class="mb-3">
                    @if($producto->stock > 5)
                        <span class="text-xs text-green-600 font-semibold">✓ En stock</span>
                    @elseif($producto->stock > 0)
                        <span class="text-xs text-orange-600 font-semibold">Pocas unidades</span>
                    @else
                        <span class="text-xs text-red-600 font-semibold">✕ Agotado</span>
                    @endif
                </div>

                <!-- Botón -->
                <a href="{{ route('tienda.producto', $producto->id) }}"
                   class="mt-auto block text-center bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2 md:py-2.5 rounded-lg transition transform hover:shadow-lg active:scale-95">
                    Ver detalles
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <p class="text-gray-500 font-semibold text-lg">No hay productos disponibles</p>
            <p class="text-gray-400 text-sm mt-2">Intenta con otros filtros</p>
        </div>
    @endforelse

</div>


</div>

@endsection
