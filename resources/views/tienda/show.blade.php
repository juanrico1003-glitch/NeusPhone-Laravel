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

            <!-- Columna Izquierda (Carrusel + Características) -->
            <div class="flex flex-col gap-6">
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

            <!-- Caracteristicas (Columna Izquierda debajo de imagen) -->
            @if($producto->caracteristicas)
                <div class="mt-4 md:mt-6 text-sm md:text-base text-gray-700 leading-relaxed bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <p class="font-semibold text-gray-800 mb-3 text-lg border-b pb-2">Características Principales</p>
                    <ul class="list-disc pl-5 space-y-1.5 marker:text-blue-500">
                        @foreach(explode("\n", $producto->caracteristicas) as $caracteristica)
                            @if(trim($caracteristica) !== '')
                                <li>{{ trim($caracteristica) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>

            <!-- Informacion del Producto (Columna Derecha) -->
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
                            <span class="font-semibold">Marca:</span> {{ $producto->marca }}
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

                <!-- Variantes de Color -->
                @if(isset($coloresDisponibles) && count($coloresDisponibles) > 0)
                <div class="mb-4">
                    <p class="text-sm font-semibold text-gray-800 mb-2">Color</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($coloresDisponibles as $c)
                            <a href="{{ route('tienda.producto', $c['producto_id']) }}" 
                               class="relative inline-flex items-center justify-center px-4 py-2 border rounded-md text-sm font-medium transition-colors
                               {{ $c['is_active'] ? 'border-blue-600 ring-2 ring-blue-600 bg-blue-50 text-blue-700' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}
                               {{ !$c['has_stock'] ? 'opacity-50 line-through' : '' }}">
                                {{ $c['color'] }}
                                @if(!$c['has_stock'])
                                    <span class="absolute text-red-500 font-bold text-lg">✕</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Variantes de RAM -->
                @if(isset($ramsDisponibles) && count($ramsDisponibles) > 0)
                <div class="mb-4">
                    <p class="text-sm font-semibold text-gray-800 mb-2">Memoria RAM</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($ramsDisponibles as $r)
                            <a href="{{ route('tienda.producto', $r['producto_id']) }}" 
                               class="relative inline-flex items-center justify-center px-4 py-2 border rounded-md text-sm font-medium transition-colors
                               {{ $r['is_active'] ? 'border-blue-600 ring-2 ring-blue-600 bg-blue-50 text-blue-700' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}
                               {{ !$r['has_stock'] ? 'opacity-50 line-through' : '' }}">
                                {{ $r['ram'] }}
                                @if(!$r['has_stock'])
                                    <span class="absolute text-red-500 font-bold text-lg">✕</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Variantes de Almacenamiento -->
                @if(isset($almacenamientosDisponibles) && count($almacenamientosDisponibles) > 0)
                <div class="mb-6 md:mb-8">
                    <p class="text-sm font-semibold text-gray-800 mb-2">Almacenamiento</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($almacenamientosDisponibles as $a)
                            <a href="{{ route('tienda.producto', $a['producto_id']) }}" 
                               class="relative inline-flex items-center justify-center px-4 py-2 border rounded-md text-sm font-medium transition-colors
                               {{ $a['is_active'] ? 'border-blue-600 ring-2 ring-blue-600 bg-blue-50 text-blue-700' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}
                               {{ !$a['has_stock'] ? 'opacity-50 line-through' : '' }}">
                                {{ $a['almacenamiento'] }}
                                @if(!$a['has_stock'])
                                    <span class="absolute text-red-500 font-bold text-lg">✕</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Botones de Acción -->
                <div class="mt-6 mb-6 flex flex-col gap-3">
                    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                        @csrf
                        <button {{ $producto->stock <= 0 ? 'disabled' : '' }}
                                class="w-full {{ $producto->stock <= 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 active:bg-blue-800' }} text-white font-bold px-6 md:px-8 py-3 md:py-4 rounded-lg transition transform {{ $producto->stock > 0 ? 'hover:shadow-lg active:scale-95' : '' }}">
                            {{ $producto->stock > 0 ? '🛒 Agregar al carrito' : '✕ Agotado' }}
                        </button>
                    </form>

                    @php
                        $mensajeWs = "Hola, me interesa el producto *" . $producto->nombre . "*";
                        if($producto->color) $mensajeWs .= " color " . $producto->color;
                        if($producto->almacenamiento) $mensajeWs .= ", " . $producto->almacenamiento . " de almacenamiento";
                        if($producto->ram) $mensajeWs .= " y " . $producto->ram . " de RAM";
                        $urlWs = "https://wa.me/573014091025?text=" . rawurlencode($mensajeWs);
                    @endphp
                    <a href="{{ $urlWs }}" target="_blank" class="w-full bg-green-500 hover:bg-green-600 active:bg-green-700 text-white font-bold px-6 md:px-8 py-3 md:py-4 rounded-lg transition transform hover:shadow-lg active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        Comprar por WhatsApp
                    </a>
                </div>

                <!-- Descripcion -->
                @if($producto->descripcion)
                    <div class="mb-4 md:mb-6 text-sm md:text-base text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-lg">
                        <p class="font-semibold text-gray-800 mb-2">Descripción</p>
                        <p>{{ $producto->descripcion }}</p>
                    </div>
                @endif

                <!-- Informacion adicional -->
                <div class="mt-6 md:mt-8 pt-6 md:pt-8 border-t border-gray-200 text-xs md:text-sm text-gray-600">
                    <p class="mb-2">✓ Envío rápido a todo el país</p>
                    <p class="mb-2">✓ Garantía incluida</p>
                    <p>✓ Soporte 24/7 disponible</p>
                </div>
            </div>

        </div>

        <!-- Sección de Comentarios (Ancho Completo) -->
        <div class="mt-12 pt-8 border-t border-gray-200 w-full">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Opiniones del Producto</h2>

            @auth
                <!-- Formulario para agregar reseña -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Deja tu opinión</h3>
                    <form action="{{ route('tienda.producto.resena', $producto->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Calificación</label>
                            <div class="flex gap-4">
                                @for($i = 5; $i >= 1; $i--)
                                    <label class="cursor-pointer flex items-center gap-1 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200 hover:bg-blue-50 transition">
                                        <input type="radio" name="calificacion" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                        <span class="text-gray-700 font-medium">{{ $i }} <span class="text-yellow-400">★</span></span>
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="comentario" class="block text-sm font-medium text-gray-700 mb-1">Tu comentario</label>
                            <textarea name="comentario" id="comentario" rows="3" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="¿Qué te pareció este producto?"></textarea>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition transform hover:scale-105 active:scale-95">
                            Publicar opinión
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-blue-50 p-4 rounded-lg mb-8 text-center border border-blue-100">
                    <p class="text-blue-800 font-medium">Para dejar una opinión, debes <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">iniciar sesión</a>.</p>
                </div>
            @endauth

            <!-- Lista de reseñas -->
            @if($producto->testimonios && $producto->testimonios->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($producto->testimonios as $testimonio)
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-sm">
                                        {{ strtoupper(substr($testimonio->usuario->nombres, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 leading-tight">{{ $testimonio->usuario->nombres }} {{ $testimonio->usuario->apellidos }}</p>
                                        <div class="flex text-yellow-400 text-sm mt-0.5">
                                            @for($i = 0; $i < 5; $i++)
                                                @if($i < $testimonio->calificacion)
                                                    ★
                                                @else
                                                    <span class="text-gray-200">★</span>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm italic">"{{ $testimonio->comentario }}"</p>
                            </div>
                            <p class="text-xs text-gray-400 mt-4 pt-3 border-t border-gray-100">{{ $testimonio->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="text-4xl mb-3">💬</div>
                    <p class="text-gray-500 font-medium">Aún no hay opiniones para este producto.</p>
                    <p class="text-gray-400 text-sm mt-1">¡Sé el primero en comentar!</p>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
