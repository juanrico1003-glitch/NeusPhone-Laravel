<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Crear Producto</h2>
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
        <form method="POST" action="{{ route('admin.productos.store') }}" enctype="multipart/form-data"
              x-data="productForm()" x-init="init()">
            @csrf

            <!-- Categoria -->
            <div class="mt-4">
                <label class="block font-medium">Categoría</label>
                <select name="categoria_id" class="w-full border rounded p-2" required
                        x-model="selectedCategory" @change="onCategoryChange">
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Marca -->
            <div class="mt-4" x-show="selectedCategory !== ''">
                <label class="block font-medium">Marca</label>
                <select name="marca" class="w-full border rounded p-2" required>
                    <option value="">Seleccione una marca</option>
                    <template x-for="marca in marcasFiltradas" :key="`marca-${selectedCategory}-${marca}`">
                        <option x-text="marca" :value="marca"></option>
                    </template>
                </select>
            </div>

            <!-- Nombre -->
            <div class="mt-4">
                <label class="block font-medium">Nombre del producto</label>
                <input type="text" name="nombre" class="w-full border rounded p-2" required
                       placeholder="Ej: Galaxy S24 Ultra, MacBook Pro 16, etc.">
            </div>

            <!-- Tipo (Nuevo/Usado) -->
            <div class="mt-4">
                <label class="block font-medium">Condición</label>
                <select name="tipo" class="w-full border rounded p-2">
                    <option value="nuevo">Nuevo</option>
                    <option value="usado">Usado</option>
                </select>
            </div>

            <!-- Color -->
            <div class="mt-4" x-show="muestraColor">
                <label class="block font-medium">Color</label>
                <select name="color" class="w-full border rounded p-2">
                    <option value="">Seleccione un color</option>
                    @foreach($colores as $color)
                        <option value="{{ $color }}">{{ $color }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Memoria RAM -->
            <div class="mt-4" x-show="muestraRam">
                <label class="block font-medium" x-text="etiquetaRam"></label>
                <select name="ram" class="w-full border rounded p-2">
                    <option value="">Seleccione</option>
                    <template x-for="ram in ramsFiltradas" :key="`ram-${selectedCategory}-${ram}`">
                        <option x-text="ram" :value="ram"></option>
                    </template>
                </select>
            </div>

            <!-- Almacenamiento -->
            <div class="mt-4" x-show="muestraAlmacenamiento">
                <label class="block font-medium" x-text="etiquetaAlmacenamiento"></label>
                <select name="almacenamiento" class="w-full border rounded p-2">
                    <option value="">Seleccione</option>
                    <template x-for="alm in almacenamientosFiltrados" :key="`almacenamiento-${selectedCategory}-${alm}`">
                        <option x-text="alm" :value="alm"></option>
                    </template>
                </select>
            </div>

            <!-- Precio -->
            <div class="mt-4">
                <label class="block font-medium">Precio</label>
                <input type="number" step="0.01" name="precio" id="precio-input" class="w-full border rounded p-2" required
                       placeholder="0.00" @input="calcularPrecioFinal">
            </div>

            <!-- Descuento -->
            <div class="mt-4">
                <label class="block font-medium">Descuento (%)</label>
                <div class="flex gap-4 items-start">
                    <div class="flex-1">
                        <input type="number" step="0.01" min="0" max="100" name="descuento"
                               value="0" id="descuento-input"
                               class="w-full border rounded p-2" @input="calcularPrecioFinal">
                        <small class="text-gray-500">Porcentaje de descuento (0 = sin oferta)</small>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg flex-1">
                        <p class="text-sm text-gray-600">Precio final:</p>
                        <p id="precio-final" class="text-lg font-bold text-green-600">$0</p>
                    </div>
                </div>
            </div>

            <!-- Stock -->
            <div class="mt-4">
                <label class="block font-medium">Stock</label>
                <input type="number" name="stock" class="w-full border rounded p-2" required
                       placeholder="0">
            </div>

            <!-- Descripcion -->
            <div class="mt-4">
                <label class="block font-medium">Descripción</label>
                <textarea name="descripcion" class="w-full border rounded p-2" rows="3"
                          placeholder="Descripción del producto..."></textarea>
            </div>

            <!-- Caracteristicas -->
            <div class="mt-4">
                <label class="block font-medium">Características</label>
                <textarea name="caracteristicas" class="w-full border rounded p-2" rows="4"
                    placeholder="Escribe una característica por línea..."></textarea>
                <small class="text-gray-500">Escribe cada característica en una nueva línea para que se muestre como lista.</small>
            </div>

            <!-- Imagen -->
            <div class="mt-4">
                <label class="block font-medium">Imágenes del producto</label>
                <input type="file" name="imagenes[]" multiple class="w-full border rounded p-2">
                <small class="text-gray-500">Puedes seleccionar múltiples imágenes (mantén presionado Ctrl o Cmd).</small>
            </div>

            <div class="mt-6">
                <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Guardar producto
                </button>
            </div>
        </form>
    </div>

    <script>
        function productForm() {
            return {
                selectedCategory: '',
                fieldConfigs: @json($fieldConfigs),
                marcasPorCategoria: @json($marcasPorCategoria),
                ramsPorCategoria: @json($ramsPorCategoria),
                almacenamientosPorCategoria: @json($almacenamientosPorCategoria),

                categoriasMap: @json($categorias->pluck('nombre', 'id')),

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
