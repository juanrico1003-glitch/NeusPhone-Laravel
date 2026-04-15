<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Pedido #{{ $pedido->id }}
        </h2>
    </x-slot>

    <div class="p-6">

        <p><strong>Cliente:</strong> {{ $pedido->usuario->nombres ?? '' }}</p>
        <p><strong>Estado actual:</strong> {{ $pedido->estado }}</p>
        <p><strong>Fecha:</strong> {{ $pedido->created_at }}</p>

        <!-- Cambiar estado -->
        <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST" class="mt-3">
            @csrf

            <select name="estado" class="border rounded p-2">
                <option value="pendiente">Pendiente</option>
                <option value="pagado">Pagado</option>
                <option value="enviado">Enviado</option>
                <option value="entregado">Entregado</option>
                <option value="cancelado">Cancelado</option>
            </select>

            <button class="ml-2 px-3 py-2 bg-green-600 text-white rounded">
                Actualizar
            </button>
        </form>

        <h3 class="font-bold mt-6 mb-3">Productos</h3>

        @foreach($detalles as $detalle)
            <div class="flex items-center border-b py-3">

                <img src="{{ asset('productos/'.(!empty($detalle->producto->imagenes) ? $detalle->producto->imagenes[0] : 'default.png')) }}"
                     width="60" class="mr-4 rounded shadow-sm">

                <div>
                    <p class="font-bold">
                        {{ $detalle->producto->nombre }}
                    </p>
                    <p>Cantidad: {{ $detalle->cantidad }}</p>
                    <p>
                        ${{ number_format($detalle->precio_unitario, 0, ',', '.') }}
                    </p>
                </div>

            </div>
        @endforeach

    </div>
</x-app-layout>
