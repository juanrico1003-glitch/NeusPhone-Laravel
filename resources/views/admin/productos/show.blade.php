<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-[#004080] leading-tight">
                Producto: {{ $producto->nombre }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.productos.edit', $producto->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Editar</a>
                <a href="{{ route('admin.productos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Información del Producto</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><span class="text-gray-500">Categoría:</span> <span class="font-medium">{{ $producto->categoria->nombre ?? '—' }}</span></div>
                        <div><span class="text-gray-500">Marca:</span> <span class="font-medium">{{ $producto->marca ?? '—' }}</span></div>
                        <div><span class="text-gray-500">Tipo:</span> <span class="font-medium">{{ ucfirst($producto->tipo ?? '—') }}</span></div>
                        <div><span class="text-gray-500">Precio:</span> <span class="font-medium text-green-600">${{ number_format($producto->precio, 0, ',', '.') }}</span></div>
                        <div><span class="text-gray-500">Stock:</span> <span class="font-medium {{ $producto->stock > 5 ? 'text-green-600' : ($producto->stock > 0 ? 'text-orange-600' : 'text-red-600') }}">{{ $producto->stock }}</span></div>
                        <div><span class="text-gray-500">Visitas:</span> <span class="font-medium">{{ $producto->visitas ?? 0 }}</span></div>
                        <div><span class="text-gray-500">Estado:</span> <span class="font-medium {{ $producto->estado ? 'text-green-600' : 'text-red-600' }}">{{ $producto->estado ? 'Activo' : 'Inactivo' }}</span></div>
                        <div><span class="text-gray-500">Color:</span> <span class="font-medium">{{ $producto->color ?? '—' }}</span></div>
                        <div><span class="text-gray-500">RAM:</span> <span class="font-medium">{{ $producto->ram ?? '—' }}</span></div>
                        <div><span class="text-gray-500">Almacenamiento:</span> <span class="font-medium">{{ $producto->almacenamiento ?? '—' }}</span></div>
                        <div><span class="text-gray-500">Procesador:</span> <span class="font-medium">{{ $producto->procesador ?? '—' }}</span></div>
                        <div><span class="text-gray-500">Tarjeta Gráfica:</span> <span class="font-medium">{{ $producto->tarjeta_grafica ?? '—' }}</span></div>
                        <div class="col-span-2"><span class="text-gray-500">Creado:</span> <span class="font-medium">{{ $producto->created_at?->format('d/m/Y h:i A') ?? '—' }}</span></div>
                    </div>
                </div>

                @if($producto->descripcion)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Descripción</h3>
                    <p class="text-sm text-gray-600">{{ $producto->descripcion }}</p>
                </div>
                @endif

                @if($producto->caracteristicas)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Características</h3>
                    <p class="text-sm text-gray-600 whitespace-pre-line">{{ $producto->caracteristicas }}</p>
                </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Imágenes</h3>
                    @if(!empty($producto->imagenes))
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($producto->imagenes as $imagen)
                            <div class="bg-gray-50 rounded-lg overflow-hidden border border-gray-200">
                                <img src="{{ asset('productos/'.$imagen) }}" alt="{{ $producto->nombre }}" class="w-full h-32 object-contain">
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400">Sin imágenes</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
