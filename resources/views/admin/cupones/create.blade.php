<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl">Nuevo cupón</h2>
    </x-slot>

    <div class="p-4 md:p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.cupones.store') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Código *</label>
                    <input type="text" name="codigo" value="{{ old('codigo') }}" required maxlength="50"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    @error('codigo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required maxlength="100"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo *</label>
                    <select name="tipo" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="porcentaje" {{ old('tipo') === 'porcentaje' ? 'selected' : '' }}>Porcentaje (%)</option>
                        <option value="fijo" {{ old('tipo') === 'fijo' ? 'selected' : '' }}>Fijo ($)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Valor *</label>
                    <input type="number" step="0.01" name="valor" value="{{ old('valor') }}" required min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    @error('valor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Compra mínima</label>
                    <input type="number" step="0.01" name="minimo_compra" value="{{ old('minimo_compra') }}" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Usos máximos</label>
                    <input type="number" name="usos_maximos" value="{{ old('usos_maximos') }}" min="1"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha inicio</label>
                    <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha fin</label>
                    <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('admin.cupones.index') }}" class="text-gray-600 hover:text-gray-800 text-sm font-medium">← Volver</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">Crear cupón</button>
            </div>
        </form>
    </div>
</x-app-layout>
