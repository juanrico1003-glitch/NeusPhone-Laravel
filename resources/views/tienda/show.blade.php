<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl md:text-3xl">
            Detalle del Producto
        </h2>
    </x-slot>

    <!-- Alertas -->
    @if(session('error'))
        <div class="bg-red-500 text-white p-3 md:p-4 rounded-lg mb-4 flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></path></svg>
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-600 text-white p-3 md:p-4 rounded-lg mb-4 flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="p-4 md:p-6 max-w-6xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 lg:gap-12">

            <!-- Carrusel imagenes Alpine.js -->
            <div x-data="{ 
                    imagenes: {{ json_encode($producto->imagenes ?? ['default.png']) }},
                    imagenActiva: 0 
                 }" class="flex flex-col gap-3 md:gap-4">
                 
                <!-- Imagen Principal -->
                <div class="w-full aspect-square bg-white rounded-xl shadow-lg border border-gray-100 flex items-center justify-center overflow-hidden relative group">
                    <template x-for="(img, index) in imagenes" :key="index">
                        <img x-show="imagenActiva === index" 
                             x-transition.opacity.duration.300ms
                             :src="'{{ asset('productos/') }}/' + img" 
                             :alt="'Producto ' + (index + 1)"
                             class="absolute inset-0 w-full h-full object-contain p-4">
                    </template>
                    
                    <!-- Controles  -->
                    <button x-show="imagenes.length > 1" 
                            @click="imagenActiva = imagenActiva === 0 ? imagenes.length - 1 : imagenActiva - 1" 
                            class="absolute left-2 md:left-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full w-9 md:w-10 h-9 md:h-10 flex items-center justify-center transition focus:outline-none opacity-0 group-hover:opacity-100">
                        <svg class="w-5 md:w-6 h-5 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    
                    <button x-show="imagenes.length > 1" 
                            @click="imagenActiva = imagenActiva === imagenes.length - 1 ? 0 : imagenActiva + 1" 
                            class="absolute right-2 md:right-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full w-9 md:w-10 h-9 md:h-10 flex items-center justify-center transition focus:outline-none opacity-0 group-hover:opacity-100">
                        <svg class="w-5 md:w-6 h-5 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>

                    <!-- Contador de imagenes -->
                    <div x-show="imagenes.length > 1" class="absolute bottom-3 right-3 bg-black/50 text-white text-xs md:text-sm px-2 md:px-3 py-1 md:py-1.5 rounded-full">
                        <span x-text="imagenActiva + 1"></span> / <span x-text="imagenes.length"></span>
                    </div>
                </div>

                <!-- Miniaturas -->
                <div x-show="imagenes.length > 1" class="flex gap-2 overflow-x-auto pb-2 snap-x">
                    <template x-for="(img, index) in imagenes" :key="index">
                        <button @click="imagenActiva = index"
                                :class="{'ring-2 ring-blue-600 opacity-100': imagenActiva === index, 'opacity-60 hover:opacity-100': imagenActiva !== index}"
                                class="flex-shrink-0 w-16 h-16 md:w-20 md:h-20 rounded-lg overflow-hidden bg-white shadow-sm border border-gray-100 transition focus:outline-none snap-start">
                            <img :src="'{{ asset('productos/') }}/' + img" :alt="'Miniatura ' + (index + 1)" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </div>

            <!-- Informacion del Producto -->
            <div class="flex flex-col">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 leading-tight mb-2">
                    {{ $producto->nombre }}
                </h1>

                <!-- Metadata -->
                <div class="flex flex-wrap gap-3 md:gap-4 mb-4 text-sm md:text-base text-gray-600">
                    @if($producto->categoria)
                        <div>
                            <span class="font-semibold">Categoría:</span> {{ $producto->categoria->nombre }}
                        </div>
                    @endif
                    @if($producto->marca)
                        <div>
                            <span class="font-semibold">Marca:</span> {{ $producto->marca->nombre }}
                        </div>
                    @endif
                </div>

                <!-- Tipo de producto -->
                <div class="mb-4">
                    <span class="inline-block px-3 py-1 text-xs md:text-sm font-bold rounded-full {{ $producto->tipo === 'nuevo' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $producto->tipo === 'nuevo' ? 'Producto Nuevo' : 'Producto Usado' }}
                    </span>
                </div>

                <!-- Precio -->
                <div class="mb-6 md:mb-8">
                    <p class="text-sm text-gray-600 mb-1">Precio</p>
                    <p class="text-3xl md:text-4xl lg:text-5xl font-bold text-green-600">
                        ${{ number_format($producto->precio, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Stock -->
                <div class="mb-6 md:mb-8">
                    @if($producto->stock > 0)
                        <span class="inline-flex items-center gap-2 text-sm md:text-base font-semibold text-green-600">
                            <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                            {{ $producto->stock }} {{ $producto->stock === 1 ? 'unidad' : 'unidades' }} disponibles
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 text-sm md:text-base font-semibold text-red-600">
                            <span class="w-2 h-2 bg-red-600 rounded-full"></span>
                            Producto agotado
                        </span>
                    @endif
                </div>

                <!-- Descripcion -->
                @if($producto->descripcion)
                    <div class="mb-6 md:mb-8 text-sm md:text-base text-gray-700 leading-relaxed">
                        <p class="font-semibold text-gray-800 mb-2">Descripción</p>
                        <p>{{ $producto->descripcion }}</p>
                    </div>
                @endif

                <!-- Boton Agregar -->
                <div class="mt-auto">
                    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                        @csrf
                        <button {{ $producto->stock <= 0 ? 'disabled' : '' }}
                                class="w-full {{ $producto->stock <= 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 active:bg-blue-800' }} text-white font-bold px-6 md:px-8 py-3 md:py-4 rounded-lg transition transform {{ $producto->stock > 0 ? 'hover:shadow-lg active:scale-95' : '' }}">
                            {{ $producto->stock > 0 ? '🛒 Agregar al carrito' : '✕ Agotado' }}
                        </button>
                    </form>
                </div>

                <!-- Informacion adicional -->
                <div class="mt-6 md:mt-8 pt-6 md:pt-8 border-t border-gray-200 text-xs md:text-sm text-gray-600">
                    <p class="mb-2">✓ Envío rápido a todo el país</p>
                    <p class="mb-2">✓ Garantía incluida</p>
                    <p>✓ Soporte 24/7 disponible</p>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
