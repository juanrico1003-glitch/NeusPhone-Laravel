<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl md:text-3xl text-gray-800">
            Resultado del Pago
        </h2>
    </x-slot>

    <div class="py-6 md:py-8 max-w-3xl mx-auto">
        
        @if(!empty($errorMsg))
            <!-- En caso de error de conexión/API -->
            <div class="bg-red-50 border border-red-200 rounded-2xl p-6 md:p-8 text-center shadow-md mb-6">
                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Error de Verificación</h3>
                <p class="text-gray-600 mb-6">{{ $errorMsg }}</p>
                <a href="{{ route('pedidos.index') }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl transition duration-150">
                    Ir a mis pedidos
                </a>
            </div>
        @else
            @php
                $status = strtoupper($transactionData['status'] ?? 'UNKNOWN');
                $statusClass = 'bg-gray-100 text-gray-800';
                $iconColor = 'text-gray-500';
                $statusTitle = 'Estado Desconocido';
                $statusDescription = 'No pudimos verificar el estado del pago.';
                
                if ($status === 'APPROVED') {
                    $statusClass = 'bg-green-100 text-green-800';
                    $iconColor = 'text-green-600';
                    $statusTitle = '¡Pago Aprobado!';
                    $statusDescription = 'Tu pago ha sido procesado de manera exitosa. Hemos registrado tu compra y procederemos con el despacho.';
                } elseif ($status === 'PENDING') {
                    $statusClass = 'bg-yellow-100 text-yellow-800';
                    $iconColor = 'text-yellow-600';
                    $statusTitle = 'Pago en Proceso';
                    $statusDescription = 'Wompi está procesando tu pago. Esto puede tomar unos minutos. Actualizaremos el pedido de forma automática.';
                } elseif (in_array($status, ['DECLINED', 'VOIDED', 'ERROR'])) {
                    $statusClass = 'bg-red-100 text-red-800';
                    $iconColor = 'text-red-600';
                    $statusTitle = 'Pago Rechazado o Fallido';
                    $statusDescription = 'La transacción no pudo ser completada. Puedes intentar realizar el pago nuevamente.';
                }
            @endphp

            <div class="bg-white shadow-md rounded-2xl p-6 md:p-8 border border-blue-100 text-center mb-8">
                <!-- Icono Dinámico -->
                <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4 {{ $status === 'APPROVED' ? 'bg-green-100' : ($status === 'PENDING' ? 'bg-yellow-100' : 'bg-red-100') }}">
                    @if($status === 'APPROVED')
                        <svg class="w-10 h-10 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @elseif($status === 'PENDING')
                        <svg class="w-10 h-10 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-10 h-10 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    @endif
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $statusTitle }}</h3>
                <p class="text-gray-600 max-w-xl mx-auto mb-6">{{ $statusDescription }}</p>

                <!-- Tarjeta con Detalles -->
                <div class="bg-blue-50/50 rounded-xl p-5 text-left border border-blue-100 max-w-xl mx-auto mb-6 text-sm">
                    <h4 class="font-bold text-gray-800 mb-3 border-b border-blue-100 pb-1.5">Detalles de Transacción</h4>
                    
                    <div class="grid grid-cols-2 gap-y-2 text-gray-600">
                        <span class="font-medium">Pedido ID:</span>
                        <span class="font-bold text-gray-800">#{{ $pedido->id ?? 'N/A' }}</span>
                        
                        <span class="font-medium">Referencia de pago:</span>
                        <span class="font-bold text-gray-800">{{ $transactionData['reference'] ?? 'N/A' }}</span>
                        
                        <span class="font-medium">ID Transacción Wompi:</span>
                        <span class="font-bold text-gray-800">{{ $transactionData['id'] ?? 'N/A' }}</span>
                        
                        <span class="font-medium">Medio de pago:</span>
                        <span class="font-bold text-gray-800">{{ $transactionData['payment_method_type'] ?? 'N/A' }}</span>
                        
                        <span class="font-medium">Valor total:</span>
                        <span class="font-bold text-green-600">
                            ${{ number_format(($transactionData['amount_in_cents'] ?? 0) / 100, 0, ',', '.') }} COP
                        </span>

                        <span class="font-medium">Fecha:</span>
                        <span class="font-bold text-gray-800">
                            {{ isset($transactionData['created_at']) ? date('d/m/Y h:i A', strtotime($transactionData['created_at'])) : 'N/A' }}
                        </span>
                    </div>
                </div>

                @if($pedido && $pedido->envio)
                    <!-- Datos de envío -->
                    <div class="bg-gray-50 rounded-xl p-5 text-left border border-gray-100 max-w-xl mx-auto mb-8 text-sm">
                        <h4 class="font-bold text-gray-800 mb-3 border-b border-gray-200 pb-1.5">Dirección de Envío</h4>
                        <div class="grid grid-cols-2 gap-y-2 text-gray-600">
                            <span class="font-medium">Destinatario:</span>
                            <span class="font-bold text-gray-800">{{ $pedido->envio->nombre_contacto }}</span>

                            <span class="font-medium">Cédula:</span>
                            <span class="font-bold text-gray-800">CC. {{ $pedido->envio->cedula_contacto }}</span>

                            <span class="font-medium">Teléfono:</span>
                            <span class="font-bold text-gray-800">{{ $pedido->envio->telefono_contacto }}</span>

                            <span class="font-medium">Dirección:</span>
                            <span class="font-bold text-gray-800">{{ $pedido->envio->direccion }}</span>

                            @if($pedido->envio->nombre_lugar)
                                <span class="font-medium">
                                    @if($pedido->envio->tipo_lugar === 'casa') Casa/Condo: 
                                    @elseif($pedido->envio->tipo_lugar === 'apartamento') Apto/Torre: 
                                    @elseif($pedido->envio->tipo_lugar === 'oficina_empresa') Empresa: 
                                    @elseif($pedido->envio->tipo_lugar === 'edificio') Edificio: 
                                    @else Lugar: @endif
                                </span>
                                <span class="font-bold text-gray-800">{{ $pedido->envio->nombre_lugar }}</span>
                            @endif

                            @if($pedido->envio->detalles_envio)
                                <span class="font-medium">Indicaciones:</span>
                                <span class="font-bold text-gray-800">{{ $pedido->envio->detalles_envio }}</span>
                            @endif

                            <span class="font-medium">Ciudad / Depto:</span>
                            <span class="font-bold text-gray-800">{{ $pedido->envio->municipio }}, {{ $pedido->envio->departamento }}</span>
                        </div>
                    </div>
                @endif

                <!-- Botones finales -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    @if(in_array($status, ['DECLINED', 'VOIDED', 'ERROR']) && $pedido)
                        <a href="{{ route('checkout.pagar', $pedido->id) }}" 
                           class="w-full sm:w-auto bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-extrabold px-6 py-3 rounded-xl shadow-md transition transform hover:-translate-y-0.5 active:translate-y-0 text-center">
                            ✕ Reintentar Pago
                        </a>
                    @endif

                    <a href="{{ route('pedidos.index') }}" 
                       class="w-full sm:w-auto bg-[#004080] hover:bg-[#003366] text-white font-bold px-6 py-3 rounded-xl shadow-md transition duration-150 text-center">
                        Ver mis pedidos
                    </a>

                    <a href="{{ route('tienda') }}" 
                       class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-6 py-3 rounded-xl transition duration-150 text-center">
                        Seguir comprando
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
