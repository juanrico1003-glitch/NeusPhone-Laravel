<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Pedido #{{ $pedido->id }}
        </h2>
    </x-slot>

    <div class="p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white p-5 rounded-xl border shadow-sm">
                <h3 class="font-bold text-gray-800 mb-3 border-b pb-2">Información del Pedido</h3>
                <p><strong>Cliente:</strong> {{ $pedido->usuario->nombres ?? '' }} {{ $pedido->usuario->apellidos ?? '' }}</p>
                <p><strong>Estado actual:</strong> <span class="capitalize px-2 py-0.5 rounded text-xs font-bold {{ $pedido->estado === 'pagado' ? 'bg-green-100 text-green-800' : ($pedido->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">{{ $pedido->estado }}</span></p>
                <p><strong>Fecha:</strong> {{ $pedido->created_at }}</p>
                <p class="text-lg font-bold text-green-600 mt-2">
                    Total: ${{ number_format($pedido->total, 0, ',', '.') }}
                </p>

                <!-- Cambiar estado -->
                <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST" class="mt-4 flex items-center gap-2">
                    @csrf
                    <select name="estado" class="border rounded p-2 text-sm">
                        <option value="pendiente" {{ $pedido->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="pagado" {{ $pedido->estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
                        <option value="enviado" {{ $pedido->estado === 'enviado' ? 'selected' : '' }}>Enviado</option>
                        <option value="entregado" {{ $pedido->estado === 'entregado' ? 'selected' : '' }}>Entregado</option>
                        <option value="cancelado" {{ $pedido->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>

                    <button class="px-3 py-2 bg-blue-600 text-white rounded text-sm font-semibold hover:bg-blue-700">
                        Actualizar
                    </button>
                </form>
            </div>

            @if($pedido->envio)
            <div class="bg-white p-5 rounded-xl border shadow-sm text-sm">
                <h3 class="font-bold text-gray-800 mb-3 border-b pb-2">Dirección de Envío y Facturación</h3>
                <p class="mb-1"><strong>Destinatario:</strong> {{ $pedido->envio->nombre_contacto }}</p>
                <p class="mb-1"><strong>Documento:</strong> CC. {{ $pedido->envio->cedula_contacto }}</p>
                <p class="mb-1"><strong>Teléfono:</strong> {{ $pedido->envio->telefono_contacto }}</p>
                <p class="mb-1"><strong>Dirección:</strong> {{ $pedido->envio->direccion }}</p>
                @if($pedido->envio->nombre_lugar)
                    <p class="mb-1"><strong>
                        @if($pedido->envio->tipo_lugar === 'casa') Casa/Condo: 
                        @elseif($pedido->envio->tipo_lugar === 'apartamento') Apto/Torre: 
                        @elseif($pedido->envio->tipo_lugar === 'oficina_empresa') Empresa: 
                        @elseif($pedido->envio->tipo_lugar === 'edificio') Edificio: 
                        @else Lugar: @endif
                    </strong> {{ $pedido->envio->nombre_lugar }}</p>
                @endif
                @if($pedido->envio->detalles_envio)
                    <p class="mb-1"><strong>Indicaciones:</strong> {{ $pedido->envio->detalles_envio }}</p>
                @endif
                <p class="mb-1"><strong>Ciudad:</strong> {{ $pedido->envio->municipio }}, {{ $pedido->envio->departamento }}</p>
                @if($pedido->wompi_transaction_id)
                    <p class="mt-2 text-xs text-gray-500"><strong>Wompi ID:</strong> {{ $pedido->wompi_transaction_id }} ({{ $pedido->wompi_payment_method }})</p>
                @endif
            </div>
            @endif
        </div>

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
