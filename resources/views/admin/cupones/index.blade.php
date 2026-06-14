<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl">Cupones de descuento</h2>
    </x-slot>

    <div class="p-4 md:p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.cupones.create') }}" class="inline-block px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition mb-6">
            + Nuevo cupón
        </a>

        <div class="overflow-x-auto mt-4">
            <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left font-semibold text-gray-700">Código</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Nombre</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Tipo</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Valor</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Usos</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Vigencia</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Estado</th>
                        <th class="p-3 text-left font-semibold text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cupones as $cupon)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 font-mono font-bold text-sm">{{ $cupon->codigo }}</td>
                        <td class="p-3">{{ $cupon->nombre }}</td>
                        <td class="p-3">{{ $cupon->tipo === 'porcentaje' ? '%' : '$' }}</td>
                        <td class="p-3 font-semibold">
                            {{ $cupon->tipo === 'porcentaje' ? $cupon->valor . '%' : '$' . number_format($cupon->valor, 0, ',', '.') }}
                        </td>
                        <td class="p-3 text-sm">{{ $cupon->usos_actuales }} / {{ $cupon->usos_maximos ?? '∞' }}</td>
                        <td class="p-3 text-sm">
                            @if($cupon->fecha_inicio && $cupon->fecha_fin)
                                {{ $cupon->fecha_inicio->format('d/m/Y') }} - {{ $cupon->fecha_fin->format('d/m/Y') }}
                            @elseif($cupon->fecha_inicio)
                                Desde {{ $cupon->fecha_inicio->format('d/m/Y') }}
                            @elseif($cupon->fecha_fin)
                                Hasta {{ $cupon->fecha_fin->format('d/m/Y') }}
                            @else
                                Sin fecha
                            @endif
                        </td>
                        <td class="p-3">
                            <span class="text-xs font-bold px-2 py-1 rounded-full {{ $cupon->esValido() ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                {{ $cupon->esValido() ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="p-3 flex gap-2">
                            <a href="{{ route('admin.cupones.edit', $cupon) }}" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded">Editar</a>
                            <form action="{{ route('admin.cupones.destroy', $cupon) }}" method="POST" onsubmit="return confirm('¿Eliminar este cupón?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm rounded">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="p-6 text-center text-gray-500">No hay cupones registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
