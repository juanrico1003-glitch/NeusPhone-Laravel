<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl md:text-3xl">
            Carrito de Compras
        </h2>
    </x-slot>

    <div class="p-4 md:p-6">

        @php $total = 0; @endphp

        @forelse($carrito as $id => $item)

            @php $total += $item['precio'] * $item['cantidad']; @endphp

            <div class="flex flex-col sm:flex-row sm:items-center gap-4 border-b py-4 md:py-6 hover:bg-gray-50/50 rounded-lg px-2 md:px-4 transition">

                <!-- Imagen -->
                <div class="flex-shrink-0 w-full sm:w-24 h-24 sm:h-24 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('productos/'.$item['imagen']) }}"
                         alt="{{ $item['nombre'] }}"
                         class="w-full h-full object-contain p-2">
                </div>

                <!-- Informacion -->
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-base md:text-lg text-gray-800 truncate">{{ $item['nombre'] }}</h3>
                    <p class="text-sm text-gray-600 mt-1">Cantidad: <span class="font-semibold">{{ $item['cantidad'] }}</span></p>
                    <p class="text-lg md:text-xl font-bold text-green-600 mt-2">
                        ${{ number_format($item['precio'], 0, ',', '.') }}
                    </p>
                </div>

                <!-- Boton Quitar -->
                <div class="flex-shrink-0">
                    <a href="{{ route('carrito.eliminar', $id) }}"
                       class="block w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg font-medium text-center transition transform active:scale-95">
                        ✕ Quitar
                    </a>
                </div>

            </div>

        @empty
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg font-semibold">El carrito está vacío</p>
                <a href="{{ route('tienda') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    Ir a comprar
                </a>
            </div>
        @endforelse

        @if(count($carrito) > 0)
            <!-- Resumen -->
            <div class="mt-8 bg-blue-50 rounded-lg p-6 max-w-md ml-auto">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-700 font-medium text-lg">Total:</span>
                    <span class="text-2xl md:text-3xl font-bold text-green-600">
                        ${{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
                
                <form action="{{ route('carrito.confirmar') }}" method="POST">
                    @csrf
                    <button class="w-full mt-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold px-6 py-3 md:py-4 rounded-lg transition transform hover:scale-105 active:scale-95">
                        ✓ Confirmar compra
                    </button>
                </form>

                <a href="{{ route('tienda') }}" class="block w-full mt-3 text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-6 py-3 rounded-lg transition">
                    ← Seguir comprando
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
