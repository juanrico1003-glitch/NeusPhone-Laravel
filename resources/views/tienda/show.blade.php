<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Detalle del Producto
        </h2>
    </x-slot>

    @if(session('error'))
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="bg-green-600 text-white p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

    <div class="p-6 max-w-5xl mx-auto">

        <div class="grid md:grid-cols-2 gap-8">

            <!-- Carrusel de Imágenes con Alpine.js -->
            <div x-data="{ 
                    imagenes: {{ json_encode($producto->imagenes ?? ['default.png']) }},
                    imagenActiva: 0 
                 }" class="flex flex-col gap-4">
                 
                <!-- Imagen Principal -->
                <div class="w-full h-96 relative bg-white rounded-xl shadow-lg border border-gray-100 flex items-center justify-center overflow-hidden">
                    <template x-for="(img, index) in imagenes" :key="index">
                        <img x-show="imagenActiva === index" 
                             x-transition.opacity.duration.300ms
                             :src="'{{ asset('productos/') }}/' + img" 
                             class="absolute inset-0 w-full h-full object-contain p-4">
                    </template>
                    
                    <!-- Controles Izquierda/Derecha -->
                    <button x-show="imagenes.length > 1" @click="imagenActiva = imagenActiva === 0 ? imagenes.length - 1 : imagenActiva - 1" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white rounded-full w-10 h-10 flex items-center justify-center transition focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    
                    <button x-show="imagenes.length > 1" @click="imagenActiva = imagenActiva === imagenes.length - 1 ? 0 : imagenActiva + 1" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white rounded-full w-10 h-10 flex items-center justify-center transition focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                <!-- Miniaturas -->
                <div x-show="imagenes.length > 1" class="flex gap-2 overflow-x-auto pb-2 snap-x">
                    <template x-for="(img, index) in imagenes" :key="index">
                        <button @click="imagenActiva = index"
                                :class="{'ring-2 ring-blue-600 opacity-100': imagenActiva === index, 'opacity-60 hover:opacity-100': imagenActiva !== index}"
                                class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-white shadow-sm border border-gray-100 transition focus:outline-none snap-start">
                            <img :src="'{{ asset('productos/') }}/' + img" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </div>

            <!-- Informacion -->
            <div>
                <h1 class="text-2xl font-bold">
                    {{ $producto->nombre }}
                </h1>

                <p class="mt-2 text-gray-600">
                    Categoría: {{ $producto->categoria->nombre ?? '' }}
                </p>

                <p class="text-gray-600">
                    Marca: {{ $producto->marca->nombre ?? '' }}
                </p>

                <p class="mt-4 text-3xl text-green-600 font-semibold">
                    ${{ number_format($producto->precio, 0, ',', '.') }}
                </p>

                <p class="mt-4">
                    {{ $producto->descripcion }}
                </p>

                <div class="mt-6">
                    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
    @csrf
    <button class="bg-blue-600 text-white px-6 py-3 rounded">
        Agregar al carrito
    </button>
</form>

                </div>
            </div>

        </div>

    </div>
</x-app-layout>
