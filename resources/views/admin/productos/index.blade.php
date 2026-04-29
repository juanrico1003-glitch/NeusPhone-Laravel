<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl md:text-3xl">
            Gestión de Productos
        </h2>
    </x-slot>

    <div class="p-4 md:p-6">

        <a href="{{ route('admin.productos.create') }}"
           class="inline-block px-4 md:px-6 py-2 md:py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
            ➕ Nuevo producto
        </a>

        <!-- Vista de tabla -->
        <div class="mt-6 hidden md:block overflow-x-auto">
            <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left font-semibold text-gray-700">Imagen</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Nombre</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Categoría</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Marca</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Precio</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Stock</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Estado</th>
                        <th class="p-3 text-center font-semibold text-gray-700">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($productos as $producto)
                        <tr class="border-t hover:bg-gray-50 transition">

                            <td class="p-3">
                                @if(!empty($producto->imagenes))
                                    <img src="{{ asset('productos/'.$producto->imagenes[0]) }}" class="w-12 h-12 md:w-16 md:h-16 object-cover rounded" alt="{{ $producto->nombre }}">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-400">Sin img</div>
                                @endif
                            </td>

                            <td class="p-3 font-medium text-gray-800 max-w-xs truncate">{{ $producto->nombre }}</td>

                            <td class="p-3 text-gray-600">
                                {{ $producto->categoria->nombre ?? '-' }}
                            </td>

                            <td class="p-3 text-gray-600">
                                {{ $producto->marca->nombre ?? '-' }}
                            </td>

                            <td class="p-3 font-bold text-green-600">
                                ${{ number_format($producto->precio, 0, ',', '.') }}
                            </td>

                            <td class="p-3 text-center">
                                <span class="px-2 py-1 rounded text-sm font-semibold {{ $producto->stock > 5 ? 'bg-green-100 text-green-800' : ($producto->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $producto->stock }}
                                </span>
                            </td>

                            <td class="p-3">
                                @if($producto->estado == 1)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-bold">Activo</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm font-bold">Inactivo</span>
                                @endif
                            </td>

                            <td class="p-3 flex flex-col gap-2">

                                <a href="{{ route('admin.productos.estado', $producto->id) }}"
                                   class="w-full text-center px-2 py-1 text-xs bg-gray-600 hover:bg-gray-700 text-white rounded transition">
                                    @if($producto->estado == 1)
                                        Desactivar
                                    @else
                                        Activar
                                    @endif
                                </a>

                                <a href="{{ route('admin.productos.edit', $producto->id) }}"
                                   class="w-full text-center px-2 py-1 text-xs bg-yellow-500 hover:bg-yellow-600 text-white rounded transition">
                                    Editar
                                </a>

                                <form action="{{ route('admin.productos.destroy', $producto->id) }}"
                                      method="POST" class="w-full" onsubmit="return confirm('¿Eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="w-full text-center px-2 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition">
                                        Borrar
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-4 text-center text-gray-500 font-medium">
                                No hay productos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Vista tarjetas -->
        <div class="mt-6 md:hidden grid grid-cols-1 gap-4">
            @forelse($productos as $producto)
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex gap-4">
                        <!-- Imagen -->
                        <div class="flex-shrink-0">
                            @if(!empty($producto->imagenes))
                                <img src="{{ asset('productos/'.$producto->imagenes[0]) }}" class="w-16 h-16 md:w-20 md:h-20 object-cover rounded" alt="{{ $producto->nombre }}">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs text-center">Sin img</div>
                            @endif
                        </div>

                        <!-- Contenido -->
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-800 truncate">{{ $producto->nombre }}</h3>
                            <p class="text-sm text-gray-600 truncate">{{ $producto->categoria->nombre ?? '-' }}</p>
                            <p class="text-sm text-gray-600 truncate">{{ $producto->marca->nombre ?? '-' }}</p>
                            
                            <div class="flex justify-between items-end mt-2">
                                <div>
                                    <p class="text-lg font-bold text-green-600">${{ number_format($producto->precio, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">Stock: <span class="font-bold">{{ $producto->stock }}</span></p>
                                </div>
                                <span class="px-2 py-1 text-xs font-bold rounded-full {{ $producto->estado == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $producto->estado == 1 ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <a href="{{ route('admin.productos.estado', $producto->id) }}"
                           class="py-2 text-xs bg-gray-600 hover:bg-gray-700 text-white rounded text-center font-medium transition">
                            @if($producto->estado == 1)
                                Desactivar
                            @else
                                Activar
                            @endif
                        </a>

                        <a href="{{ route('admin.productos.edit', $producto->id) }}"
                           class="py-2 text-xs bg-yellow-500 hover:bg-yellow-600 text-white rounded text-center font-medium transition">
                            Editar
                        </a>

                        <form action="{{ route('admin.productos.destroy', $producto->id) }}"
                              method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf
                            @method('DELETE')

                            <button class="w-full py-2 text-xs bg-red-600 hover:bg-red-700 text-white rounded font-medium transition">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 font-medium col-span-full">
                    No hay productos registrados
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
