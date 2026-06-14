<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Variantes de: {{ $producto->nombre }}</h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">{{ session('success') }}</div>
        @endif

        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('admin.productos.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Volver a productos</a>
        </div>

        <!-- Formulario nueva variante -->
        <div class="bg-white p-6 rounded-xl border mb-8">
            <h3 class="font-bold text-lg mb-4">Agregar variante</h3>
            <form method="POST" action="{{ route('admin.productos.variantes.store', $producto->id) }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Color</label>
                    <select name="color" class="w-full border rounded p-2 text-sm">
                        <option value="">-</option>
                        @foreach($colores as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">RAM</label>
                    <select name="ram" class="w-full border rounded p-2 text-sm">
                        <option value="">-</option>
                        @foreach($rams as $r)
                        <option value="{{ $r }}">{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Almacenamiento</label>
                    <select name="almacenamiento" class="w-full border rounded p-2 text-sm">
                        <option value="">-</option>
                        @foreach($almacenamientos as $a)
                        <option value="{{ $a }}">{{ $a }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">SKU</label>
                    <input type="text" name="sku" class="w-full border rounded p-2 text-sm" placeholder="Opcional">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Precio adicional</label>
                    <input type="number" name="precio_adicional" value="0" step="0.01" class="w-full border rounded p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Stock</label>
                    <input type="number" name="stock" value="0" class="w-full border rounded p-2 text-sm" required>
                </div>
                <div class="md:col-span-6">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Agregar variante</button>
                </div>
            </form>
        </div>

        <!-- Tabla de variantes -->
        <div class="bg-white rounded-xl border overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">Color</th>
                        <th class="p-3 text-left">RAM</th>
                        <th class="p-3 text-left">Almacenamiento</th>
                        <th class="p-3 text-left">SKU</th>
                        <th class="p-3 text-right">Precio adicional</th>
                        <th class="p-3 text-center">Stock</th>
                        <th class="p-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($variantes as $v)
                    <tr class="border-t">
                        <td class="p-3">{{ $v->color ?? '-' }}</td>
                        <td class="p-3">{{ $v->ram ?? '-' }}</td>
                        <td class="p-3">{{ $v->almacenamiento ?? '-' }}</td>
                        <td class="p-3 text-gray-500 text-xs">{{ $v->sku ?? '-' }}</td>
                        <td class="p-3 text-right">${{ number_format($v->precio_adicional, 0, ',', '.') }}</td>
                        <td class="p-3 text-center">
                            <span class="px-2 py-1 rounded font-semibold {{ $v->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $v->stock }}
                            </span>
                        </td>
                        <td class="p-3 text-center">
                            <form method="POST" action="{{ route('admin.productos.variantes.destroy', [$producto->id, $v->id]) }}" class="inline" onsubmit="return confirm('¿Eliminar esta variante?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 text-xs font-medium">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="p-6 text-center text-gray-500">No hay variantes. Crea una arriba.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
