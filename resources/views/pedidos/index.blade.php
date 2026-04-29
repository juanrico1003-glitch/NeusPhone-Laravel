<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Mis pedidos
        </h2>
    </x-slot>

    <div class="p-6">

        @forelse($pedidos as $pedido)

            <div class="border rounded p-4 mb-4 shadow">

                <div class="flex justify-between">
                    <div>
                        <p class="font-bold">
                            Pedido #{{ $pedido->id }}
                        </p>
                        <p>
                            Estado: {{ $pedido->estado }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold">
                            ${{ number_format($pedido->total, 0, ',', '.') }}
                        </p>
                        <p class="text-sm">
                            {{ $pedido->created_at }}
                        </p>
                        <div class="mt-3 space-x-2 flex justify-end">
                            <a href="{{ route('pedidos.show', $pedido->id) }}"
                               class="inline-block bg-blue-600 text-white px-4 py-2 rounded text-sm">
                                Ver detalle
                            </a>
                            @if(strtolower($pedido->estado) == 'entregado')
                            <a href="{{ route('testimonios.create') }}"
                               class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm shadow-md font-bold">
                                ⭐ Calificar
                            </a>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

        @empty
            <p>No has realizado compras todavía</p>
        @endforelse

    </div>
</x-app-layout>
