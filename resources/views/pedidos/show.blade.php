<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Detalle del pedido #{{ $pedido->id }}
        </h2>
    </x-slot>

    <div class="p-6">

        <div class="mb-6">
            <p><strong>Estado:</strong> {{ $pedido->estado }}</p>
            <p><strong>Fecha:</strong> {{ $pedido->created_at }}</p>
            <p class="text-lg font-bold">
                Total: ${{ number_format($pedido->total, 0, ',', '.') }}
            </p>
        </div>

        <h3 class="font-bold mb-3">Productos</h3>

        @foreach($detalles as $detalle)
    <div class="flex items-center border-b py-3">

        <img src="{{ asset('productos/'.(!empty($detalle->producto->imagenes) ? $detalle->producto->imagenes[0] : 'default.png')) }}"
             width="70" class="mr-4">

        <div class="flex-1">
            <p class="font-bold">
                {{ $detalle->producto->nombre }}
            </p>

            <p>
                Cantidad: {{ $detalle->cantidad }}
            </p>

            <p>
                Precio unidad:
                ${{ number_format($detalle->precio_unitario, 0, ',', '.') }}
            </p>
        </div>

    </div>
@endforeach

    </div>
</x-app-layout>
