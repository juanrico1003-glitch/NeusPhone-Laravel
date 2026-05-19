<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Editar Producto
        </h2>
    </x-slot>

    <div class="p-6">
        <form method="POST"
              action="{{ route('admin.productos.update', $producto->id) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="mt-4">
                <label class="block">Nombre</label>
                <input type="text" name="nombre"
                       value="{{ $producto->nombre }}"
                       class="w-full border rounded p-2">
            </div>

            <!-- Precio -->
            <div class="mt-4">
                <label class="block">Precio</label>
                <input type="number" name="precio"
                       value="{{ $producto->precio }}"
                       class="w-full border rounded p-2">
            </div>

            <!-- Stock -->
            <div class="mt-4">
                <label class="block">Stock</label>
                <input type="number" name="stock"
                       value="{{ $producto->stock }}"
                       class="w-full border rounded p-2">
            </div>

            <!-- Color -->
            <div class="mt-4">
                <label class="block">Color</label>
                <select name="color_id" class="w-full border rounded p-2">
                    <option value="">Seleccione</option>
                    @foreach($colores as $color)
                        <option value="{{ $color->id }}" {{ $producto->color_id == $color->id ? 'selected' : '' }}>
                            {{ $color->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Memoria RAM -->
            <div class="mt-4">
                <label class="block">Memoria RAM</label>
                <select name="ram_id" class="w-full border rounded p-2">
                    <option value="">Seleccione</option>
                    @foreach($rams as $ram)
                        <option value="{{ $ram->id }}" {{ $producto->ram_id == $ram->id ? 'selected' : '' }}>
                            {{ $ram->capacidad }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Almacenamiento -->
            <div class="mt-4">
                <label class="block">Almacenamiento</label>
                <select name="almacenamiento_id" class="w-full border rounded p-2">
                    <option value="">Seleccione</option>
                    @foreach($almacenamientos as $almacenamiento)
                        <option value="{{ $almacenamiento->id }}" {{ $producto->almacenamiento_id == $almacenamiento->id ? 'selected' : '' }}>
                            {{ $almacenamiento->capacidad }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Descripcion -->
            <div class="mt-4">
                <label class="block">Descripción</label>
                <textarea name="descripcion" class="w-full border rounded p-2">{{ $producto->descripcion }}</textarea>
            </div>

            <!-- Caracteristicas -->
            <div class="mt-4">
                <label class="block">Características</label>
                <textarea name="caracteristicas" class="w-full border rounded p-2" rows="4" placeholder="Escribe una característica por línea...">{{ $producto->caracteristicas }}</textarea>
                <small class="text-gray-500">Escribe cada característica en una nueva línea para que se muestre como lista.</small>
            </div>

            <!-- Imagen -->
            <div class="mb-4 mt-4">
                <label class="block mb-1">Imágenes del producto (opcional - reemplaza las actuales)</label>
                <input type="file" name="imagenes[]" multiple class="w-full border rounded p-2">
                <small class="text-gray-500">Puedes seleccionar múltiples imágenes. Si subes nuevas, reemplazarán las anteriores.</small>
            </div>

            <div class="mt-6">
                <button class="px-4 py-2 bg-green-600 text-white rounded">
                    Actualizar
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
