<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Gestión de Productos
        </h2>
    </x-slot>

    <div class="p-6">

        <a href="{{ route('admin.productos.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded">
            Nuevo producto
        </a>

        <div class="mt-6 overflow-x-auto">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2">Imagen</th>
                        <th class="p-2">Nombre</th>
                        <th class="p-2">Categoría</th>
                        <th class="p-2">Marca</th>
                        <th class="p-2">Precio</th>
                        <th class="p-2">Stock</th>
                        <th class="p-2">Estado</th>
                        <th class="p-2">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($productos as $producto)
                        <tr class="border-t">

                            <td class="p-2">
                                @if(!empty($producto->imagenes))
                                    <img src="{{ asset('productos/'.$producto->imagenes[0]) }}" width="60">
                                @endif
                            </td>

                            <td class="p-2">{{ $producto->nombre }}</td>

                            <td class="p-2">
                                {{ $producto->categoria->nombre ?? '' }}
                            </td>

                            <td class="p-2">
                                {{ $producto->marca->nombre ?? '' }}
                            </td>

                            <td class="p-2">
                                ${{ number_format($producto->precio, 0, ',', '.') }}
                            </td>

                            <td class="p-2">
                                {{ $producto->stock }}
                            </td>

                            <!-- Estado -->
                            <td class="p-2">
                                @if($producto->estado == 1)
                                    <span class="text-green-600 font-bold">Activo</span>
                                @else
                                    <span class="text-red-600 font-bold">Inactivo</span>
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td class="p-2 space-x-2">

                                <a href="{{ route('admin.productos.estado', $producto->id) }}"
                                   class="px-2 py-1 bg-gray-700 text-white rounded">
                                    @if($producto->estado == 1)
                                        Desactivar
                                    @else
                                        Activar
                                    @endif
                                </a>

                                <a href="{{ route('admin.productos.edit', $producto->id) }}"
                                   class="px-2 py-1 bg-yellow-500 text-white rounded">
                                    Editar
                                </a>

                                <form action="{{ route('admin.productos.destroy', $producto->id) }}"
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-2 py-1 bg-red-600 text-white rounded">
                                        Eliminar
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-4 text-center">
                                No hay productos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</x-app-layout>
