<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl md:text-3xl text-gray-800">
            Realizar Pago
        </h2>
    </x-slot>

    <div class="py-6 md:py-8 max-w-4xl mx-auto">
        @if($wompiError)
        <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded-lg shadow-sm mb-6">
            <p class="font-bold text-sm">Error de configuración</p>
            <p class="text-xs mt-1 font-mono">{{ $wompiError }}</p>
        </div>
        @endif

        <div class="bg-white shadow-md rounded-2xl p-6 md:p-8 border border-blue-100 mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-100 flex items-center justify-between">
                <span>Resumen del Pedido #{{ $pedido->id }}</span>
                <span class="text-xs bg-yellow-100 text-yellow-800 font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                    Pendiente de Pago
                </span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-sm text-gray-600">
                <div>
                    <h4 class="font-bold text-gray-800 mb-2">Datos de Envío</h4>
                    <p class="mb-1"><span class="font-medium text-gray-500">Destinatario:</span> {{ $pedido->envio?->nombre_contacto ?? 'No especificado' }}</p>
                    <p class="mb-1"><span class="font-medium text-gray-500">Documento:</span> CC. {{ $pedido->envio?->cedula_contacto ?? 'No especificado' }}</p>
                    <p class="mb-1"><span class="font-medium text-gray-500">Teléfono:</span> {{ $pedido->envio?->telefono_contacto ?? 'No especificado' }}</p>
                    <p class="mb-1"><span class="font-medium text-gray-500">Dirección:</span> {{ $pedido->envio?->direccion ?? 'No especificada' }}</p>
                    @if($pedido->envio?->nombre_lugar)
                        <p class="mb-1"><span class="font-medium text-gray-500">
                            @if($pedido->envio->tipo_lugar === 'casa') Casa/Condo:
                            @elseif($pedido->envio->tipo_lugar === 'apartamento') Apto/Torre:
                            @elseif($pedido->envio->tipo_lugar === 'oficina_empresa') Empresa:
                            @elseif($pedido->envio->tipo_lugar === 'edificio') Edificio:
                            @else Lugar: @endif
                        </span> {{ $pedido->envio->nombre_lugar }}</p>
                    @endif
                    @if($pedido->envio?->detalles_envio)
                        <p class="mb-1"><span class="font-medium text-gray-500">Indicaciones:</span> {{ $pedido->envio->detalles_envio }}</p>
                    @endif
                    <p><span class="font-medium text-gray-500">Ciudad:</span> {{ $pedido->envio?->municipio ?? 'No especificado' }}, {{ $pedido->envio?->departamento ?? 'No especificado' }}</p>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 mb-2">Detalles de Facturación</h4>
                    <p class="mb-1"><span class="font-medium text-gray-500">Referencia:</span> <code class="bg-gray-50 px-1.5 py-0.5 rounded border text-xs">{{ $reference }}</code></p>
                    <p class="mb-1"><span class="font-medium text-gray-500">Correo:</span> {{ $pedido->envio?->correo_contacto ?? $pedido->usuario?->correo ?? '' }}</p>
                    <p class="mb-1"><span class="font-medium text-gray-500">Fecha del pedido:</span> {{ $pedido->created_at->format('d/m/Y h:i A') }}</p>
                </div>
            </div>

            <div class="border border-gray-100 rounded-xl overflow-hidden mb-8">
                <div class="bg-gray-50 px-4 py-3 font-semibold text-gray-700 text-sm grid grid-cols-12 gap-2 border-b border-gray-100">
                    <div class="col-span-8">Producto</div>
                    <div class="col-span-2 text-center">Cant.</div>
                    <div class="col-span-2 text-right">Subtotal</div>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($pedido->detalles as $detalle)
                        <div class="px-4 py-3.5 text-sm text-gray-600 grid grid-cols-12 gap-2 items-center">
                            <div class="col-span-8 font-medium text-gray-800">
                                {{ $detalle->producto->nombre }}
                            </div>
                            <div class="col-span-2 text-center font-bold">
                                {{ $detalle->cantidad }}
                            </div>
                            <div class="col-span-2 text-right font-bold text-gray-800">
                                ${{ number_format($detalle->precio * $detalle->cantidad, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="bg-blue-50/50 px-4 py-4 font-bold text-gray-800 text-base grid grid-cols-12 gap-2 border-t border-gray-100">
                    <div class="col-span-8">Total a Pagar</div>
                    <div class="col-span-4 text-right text-lg md:text-xl text-green-600">
                        ${{ number_format($pedido->total, 0, ',', '.') }} COP
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center pt-4 border-t border-gray-100">
                <a href="{{ route('pedidos.index') }}"
                   class="w-full sm:w-auto order-3 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-6 py-3.5 rounded-xl transition duration-150">
                    ← Ver mis pedidos
                </a>

                @if(!$wompiSimulated)
                <a href="{{ $wompiCheckoutUrl }}" target="_self"
                   class="w-full sm:w-auto order-1 sm:order-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-extrabold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition duration-150 flex items-center justify-center gap-2 text-center">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Pagar con Wompi
                </a>
                @endif

                @if($wompiSimulated)
                <a href="{{ route('checkout.simular', ['pedido' => $pedido->id]) }}"
                   class="w-full sm:w-auto order-1 sm:order-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition duration-150 flex items-center justify-center gap-2 text-center">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Simular pago aprobado
                </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
