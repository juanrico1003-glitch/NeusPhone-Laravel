<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl md:text-3xl">
            Carrito de Compras
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto">

        @php $total = 0; @endphp

        @forelse($carrito as $id => $item)

            @php $total += $item['precio'] * $item['cantidad']; @endphp

            <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 border-b border-gray-200 py-4 md:py-5 rounded-lg px-2 md:px-4 transition hover:bg-gray-50/50">

                <div class="flex-shrink-0 w-full sm:w-20 md:w-24 h-20 md:h-24 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('productos/'.$item['imagen']) }}"
                         alt="{{ $item['nombre'] }}"
                         class="w-full h-full object-contain p-2">
                </div>

                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-sm md:text-lg text-gray-800 truncate">{{ $item['nombre'] }}</h3>
                    <form method="POST" action="{{ route('carrito.actualizar', $id) }}" class="flex items-center gap-2 mt-2">
                        @csrf
                        <label class="text-xs md:text-sm text-gray-600">Cant:</label>
                        <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" max="{{ $item['stock'] ?? 99 }}"
                               class="w-16 border border-gray-300 rounded px-2 py-1 text-sm text-center focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded transition font-medium">Actualizar</button>
                    </form>
                    <p class="text-base md:text-xl font-bold text-green-600 mt-2">
                        ${{ number_format($item['precio'], 0, ',', '.') }}
                    </p>
                </div>

                <div class="flex-shrink-0">
                    <a href="{{ route('carrito.eliminar', $id) }}"
                       class="block w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg font-medium text-center transition text-sm">
                        ✕ Quitar
                    </a>
                </div>

            </div>

        @empty
            <div class="text-center py-16">
                <svg class="w-16 md:w-20 h-16 md:h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                </svg>
                <p class="text-gray-500 text-lg font-semibold">El carrito está vacío</p>
                <p class="text-gray-400 text-sm mt-1">Agrega productos desde la tienda</p>
                <a href="{{ route('tienda') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg transition font-medium">
                    Ir a comprar
                </a>
            </div>
        @endforelse

        @if(count($carrito) > 0)
            <div class="mt-8 flex flex-col sm:flex-row justify-end">
                <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 border border-blue-100 w-full sm:max-w-sm">
                    <div class="flex justify-between items-center mb-4 pb-3 border-b border-blue-100">
                        <span class="text-gray-700 font-medium text-base">Total:</span>
                        <span class="text-2xl md:text-3xl font-bold text-green-600">
                            ${{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                       class="block w-full text-center bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold px-6 py-3 md:py-4 rounded-lg transition transform hover:shadow-lg active:scale-[0.98]">
                        ✓ Confirmar compra
                    </a>

                    <a href="{{ route('tienda') }}"
                       class="block w-full mt-3 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-3 rounded-lg transition text-sm">
                        ← Seguir comprando
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
