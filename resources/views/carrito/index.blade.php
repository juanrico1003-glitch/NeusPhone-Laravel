<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Carrito de Compras
        </h2>
    </x-slot>

    <div class="p-6">

        @php $total = 0; @endphp

        @forelse($carrito as $id => $item)

            @php $total += $item['precio'] * $item['cantidad']; @endphp

            <div class="flex items-center border-b py-4">

                <img src="{{ asset('productos/'.$item['imagen']) }}"
                     width="80" class="mr-4">

                <div class="flex-1">
                    <h3 class="font-bold">{{ $item['nombre'] }}</h3>
                    <p>Cantidad: {{ $item['cantidad'] }}</p>
                    <p>
                        ${{ number_format($item['precio'], 0, ',', '.') }}
                    </p>
                </div>

                <a href="{{ route('carrito.eliminar', $id) }}"
                   class="bg-red-600 text-white px-3 py-2 rounded">
                    Quitar
                </a>

            </div>

        @empty
            <p>No hay productos en el carrito</p>
        @endforelse

        <div class="mt-6 text-right text-xl font-bold">
            Total:
            ${{ number_format($total, 0, ',', '.') }}
        </div>

        @if(count($carrito) > 0)
            <form action="{{ route('carrito.confirmar') }}" method="POST" class="text-right">
                @csrf
                <button class="mt-4 bg-green-600 text-white px-6 py-3 rounded">
                    Confirmar compra
                </button>
            </form>
        @endif

    </div>
</x-app-layout>
