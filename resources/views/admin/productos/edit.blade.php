<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Editar Producto: {{ $producto->nombre }}</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('admin.productos.update', $producto->id) }}" enctype="multipart/form-data"
              x-data="productForm()" x-init="init()">
            @csrf
            @method('PUT')

            <!-- Categoría -->
            <div class="mt-4">
                <label class="block font-medium">Categoría</label>
                <select name="categoria_id" class="w-full border rounded p-2" required
                        x-model="selectedCategory" @change="onCategoryChange">
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Marca -->
            <div class="mt-4">
                <label class="block font-medium">Marca</label>
                <select name="marca" class="w-full border rounded p-2" required>
                    <option value="">Seleccione una marca</option>
                    <template x-for="marca in marcasFiltradas" :key="`marca-${selectedCategory}-${marca}`">
                        <option x-text="marca" :value="marca"
                            :selected='marca === @js($producto->marca)'></option>
                    </template>
                </select>
            </div>

            <!-- Nombre -->
            <div class="mt-4">
                <label class="block font-medium">Nombre del producto</label>
                <input type="text" name="nombre" value="{{ $producto->nombre }}"
                       class="w-full border rounded p-2" required>
            </div>

            <!-- Precio -->
            <div class="mt-4">
                <label class="block font-medium">Precio</label>
                <input type="number" step="0.01" name="precio" id="precio-input" value="{{ $producto->precio }}"
                       class="w-full border rounded p-2" required>
            </div>

            <!-- Descuento -->
            <div class="mt-4">
                <label class="block font-medium">Descuento (%)</label>
                <div class="flex gap-4 items-start">
                    <div class="flex-1">
                        <input type="number" step="0.01" min="0" max="100" name="descuento"
                               value="{{ $producto->descuento ?? 0 }}" id="descuento-input"
                               class="w-full border rounded p-2"
                               @change="calcularPrecioFinal">
                        <small class="text-gray-500">Porcentaje de descuento (0 = sin oferta)</small>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg flex-1">
                        <p class="text-sm text-gray-600">Precio final:</p>
                        <p id="precio-final" class="text-lg font-bold text-green-600">
                            ${{ number_format($producto->precio_con_descuento, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stock -->
            <div class="mt-4">
                <label class="block font-medium">Stock</label>
                <input type="number" name="stock" value="{{ $producto->stock }}"
                       class="w-full border rounded p-2" required>
            </div>

            <!-- Tipo (Nuevo/Usado) -->
            <div class="mt-4">
                <label class="block font-medium">Condición</label>
                <select name="tipo" class="w-full border rounded p-2">
                    <option value="nuevo" {{ $producto->tipo == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                    <option value="usado" {{ $producto->tipo == 'usado' ? 'selected' : '' }}>Usado</option>
                </select>
            </div>

            <!-- Color -->
            <div class="mt-4" x-show="muestraColor">
                <label class="block font-medium">Color</label>
                <select name="color" class="w-full border rounded p-2">
                    <option value="">Seleccione un color</option>
                    @foreach($colores as $color)
                        <option value="{{ $color }}" {{ $producto->color == $color ? 'selected' : '' }}>
                            {{ $color }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Memoria RAM -->
            <div class="mt-4" x-show="muestraRam">
                <label class="block font-medium" x-text="etiquetaRam"></label>
                <select name="ram" class="w-full border rounded p-2">
                    <option value="">Seleccione</option>
                    <template x-for="ram in ramsFiltradas" :key="`ram-${selectedCategory}-${ram}`">
                        <option x-text="ram" :value="ram"
                            :selected='ram === @js($producto->ram)'></option>
                    </template>
                </select>
            </div>

            <!-- Almacenamiento -->
            <div class="mt-4" x-show="muestraAlmacenamiento">
                <label class="block font-medium" x-text="etiquetaAlmacenamiento"></label>
                <select name="almacenamiento" class="w-full border rounded p-2">
                    <option value="">Seleccione</option>
                    <template x-for="alm in almacenamientosFiltrados" :key="`almacenamiento-${selectedCategory}-${alm}`">
                        <option x-text="alm" :value="alm"
                            :selected='alm === @js($producto->almacenamiento)'></option>
                    </template>
                </select>
            </div>

            <!-- Descripcion -->
            <div class="mt-4">
                <label class="block font-medium">Descripción</label>
                <textarea name="descripcion" class="w-full border rounded p-2" rows="3">{{ $producto->descripcion }}</textarea>
            </div>

            <!-- Caracteristicas -->
            <div class="mt-4">
                <label class="block font-medium">Características</label>
                <textarea name="caracteristicas" class="w-full border rounded p-2" rows="4"
                    placeholder="Escribe una característica por línea...">{{ $producto->caracteristicas }}</textarea>
                <small class="text-gray-500">Escribe cada característica en una nueva línea para que se muestre como lista.</small>
            </div>

            <!-- Imagen -->
            <div class="mb-4 mt-4">
                <label class="block font-medium">Imágenes del producto (opcional - reemplaza las actuales)</label>
                <input type="file" name="imagenes[]" multiple class="w-full border rounded p-2">
                <small class="text-gray-500">Puedes seleccionar múltiples imágenes. Si subes nuevas, reemplazarán las anteriores.</small>
            </div>

            <!-- Imágenes actuales -->
            @if($producto->imagenes)
            <div class="mt-2 flex gap-2 flex-wrap">
                @foreach($producto->imagenes as $imagen)
                    <img src="{{ asset('productos/' . $imagen) }}" class="w-20 h-20 object-cover rounded">
                @endforeach
            </div>
            @endif

            <div class="mt-6">
                <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Actualizar producto
                </button>
            </div>
        </form>

        {{-- Imágenes del producto --}}
        <div class="mt-8 p-6 bg-white rounded-xl border">
            <h3 class="font-bold text-lg mb-4">Imágenes del producto</h3>
            <div class="flex flex-wrap gap-4 mb-4">
                @php $imgs = is_array($producto->imagenes) ? $producto->imagenes : (is_string($producto->imagenes) ? json_decode($producto->imagenes, true) : []); @endphp
                @foreach($imgs as $img)
                    <img src="{{ asset('productos/'.$img) }}" class="w-24 h-24 object-cover rounded border">
                @endforeach
            </div>
            <p class="text-sm text-gray-500">Las imágenes se gestionan desde el campo "imagenes" en el formulario superior.</p>
        </div>
    </div>

    <script>
        function productForm() {
            return {
                selectedCategory: '{{ $producto->categoria_id }}',
                categoriasMap: @json($categorias->pluck('nombre', 'id')),
                fieldConfigs: @json($fieldConfigs),
                marcasPorCategoria: @json($marcasPorCategoria),
                ramsPorCategoria: @json($ramsPorCategoria),
                almacenamientosPorCategoria: @json($almacenamientosPorCategoria),

                init() {},

                get camposCategoria() {
                    return this.fieldConfigs[this.selectedCategory] || [];
                },

                get muestraColor() {
                    return this.camposCategoria.includes('color');
                },

                get muestraRam() {
                    return this.camposCategoria.includes('ram');
                },

                get muestraAlmacenamiento() {
                    return this.camposCategoria.includes('almacenamiento');
                },

                get marcasFiltradas() {
                    return this.marcasPorCategoria[this.selectedCategory] || [];
                },

                get ramsFiltradas() {
                    return this.ramsPorCategoria[this.selectedCategory] || [];
                },

                get almacenamientosFiltrados() {
                    return this.almacenamientosPorCategoria[this.selectedCategory] || [];
                },

                get categoriaNombre() {
                    return this.categoriasMap[this.selectedCategory] || '';
                },

                get etiquetaRam() {
                    const nom = this.categoriaNombre;
                    if (nom === 'Memorias RAM') return 'Capacidad de la Memoria RAM';
                    if (nom === 'Tarjetas Gráficas') return 'VRAM (Memoria de Video)';
                    return 'Memoria RAM';
                },

                get etiquetaAlmacenamiento() {
                    const nom = this.categoriaNombre;
                    if (nom === 'Discos SSD') return 'Capacidad del SSD';
                    if (nom === 'Discos HDD') return 'Capacidad del Disco Duro';
                    return 'Almacenamiento';
                },

                onCategoryChange() {
                    const marcaSelect = document.querySelector('select[name="marca"]');
                    const ramSelect = document.querySelector('select[name="ram"]');
                    const almacenamientoSelect = document.querySelector('select[name="almacenamiento"]');
                    const colorSelect = document.querySelector('select[name="color"]');
                    if (marcaSelect) marcaSelect.value = '';
                    if (ramSelect) ramSelect.value = '';
                    if (almacenamientoSelect) almacenamientoSelect.value = '';
                    if (colorSelect) colorSelect.value = '';
                },
                calcularPrecioFinal() {
                    const precio = parseFloat(document.getElementById('precio-input').value) || 0;
                    const descuento = parseFloat(document.getElementById('descuento-input').value) || 0;
                    const final = descuento > 0 ? precio - (precio * descuento / 100) : precio;
                    document.getElementById('precio-final').textContent = '$' + Math.round(final).toLocaleString('es-CO');
                }
            }
        }
    </script>
</x-app-layout>
