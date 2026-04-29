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

            <!-- Imagen -->
            <div class="mb-4">
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
