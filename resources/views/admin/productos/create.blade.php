<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Crear Producto
        </h2>
    </x-slot>

    @if ($errors->any())
    <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="p-6">
        <form method="POST"
      action="{{ route('admin.productos.store') }}"
      enctype="multipart/form-data">
            @csrf

            <!-- Categoría -->
            <div class="mt-4">
                <label class="block">Categoría</label>
                <select name="categoria_id" class="w-full border rounded p-2" required>
                    <option value="">Seleccione</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Marca -->
            <div class="mt-4">
                <label class="block">Marca</label>
                <select name="marca_id" class="w-full border rounded p-2" required>
                    <option value="">Seleccione</option>
                    @foreach($marcas as $marca)
                        <option value="{{ $marca->id }}">
                            {{ $marca->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nombre -->
            <div class="mt-4">
                <label class="block">Nombre</label>
                <input type="text" name="nombre" class="w-full border rounded p-2" required>
            </div>

            <!-- Tipo -->
            <div class="mt-4">
                <label class="block">Condición</label>
                <select name="tipo" class="w-full border rounded p-2">
                    <option value="nuevo">Nuevo</option>
                    <option value="usado">Usado</option>
                </select>
            </div>

            <!-- Color -->
            <div class="mt-4">
                <label class="block">Color</label>
                <select name="color_id" class="w-full border rounded p-2">
                    @foreach($colores as $color)
                        <option value="{{ $color->id }}">
                            {{ $color->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Almacenamiento -->
            <div class="mt-4">
                <label class="block">Almacenamiento</label>
                <select name="almacenamiento_id" class="w-full border rounded p-2">
                    @foreach($almacenamientos as $almacenamiento)
                        <option value="{{ $almacenamiento->id }}">
                            {{ $almacenamiento->capacidad }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Precio -->
            <div class="mt-4">
                <label class="block">Precio</label>
                <input type="number" step="0.01" name="precio" class="w-full border rounded p-2" required>
            </div>

            <!-- Stock -->
            <div class="mt-4">
                <label class="block">Stock</label>
                <input type="number" name="stock" class="w-full border rounded p-2" required>
            </div>

            <!-- Descripción -->
            <div class="mt-4">
                <label class="block">Descripción</label>
                <textarea name="descripcion" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="mt-4">
                <label class="block">Imagen del producto</label>
                <input type="file" name="imagenes[]" multiple class="w-full border rounded p-2">
                <small class="text-gray-500">Puedes seleccionar múltiples imágenes (mantén presionado Ctrl o Cmd).</small>
            </div>

            <div class="mt-6">
                <button class="px-4 py-2 bg-green-600 text-white rounded">
                    Guardar producto
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
