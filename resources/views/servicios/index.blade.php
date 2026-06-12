<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Mis solicitudes de servicio</h2>
            <a href="{{ route('servicios.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-5 py-2 rounded-lg transition">+ Nueva solicitud</a>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 max-w-5xl mx-auto space-y-4">
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-lg text-sm">{{ session('success') }}</div>
        @endif

        @forelse($servicios as $s)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-3 border-b border-gray-50">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-mono font-bold text-gray-400">#{{ $s->id }}</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $s->servicio?->nombre ?? 'Servicio' }}</span>
                </div>
                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide
                    @if($s->estado === 'pendiente') bg-yellow-50 text-yellow-600
                    @elseif($s->estado === 'en_revision') bg-blue-50 text-blue-600
                    @elseif($s->estado === 'reparado') bg-green-50 text-green-600
                    @elseif($s->estado === 'entregado') bg-indigo-50 text-indigo-600
                    @else bg-red-50 text-red-600 @endif">
                    @switch($s->estado)
                        @case('pendiente') Pendiente @break
                        @case('en_revision') En revisión @break
                        @case('reparado') Reparado @break
                        @case('entregado') Entregado @break
                        @case('cancelado') Cancelado @break
                        @default {{ $s->estado }}
                    @endswitch
                </span>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Equipo</p>
                    <p class="font-medium text-gray-800">
                        @if($s->tipo_equipo)
                            {{ ucfirst($s->tipo_equipo) }}
                            @if($s->marca_equipo) · {{ $s->marca_equipo }} @endif
                            @if($s->modelo_equipo) · {{ $s->modelo_equipo }} @endif
                        @else
                            Sin especificar
                        @endif
                    </p>
                    @if($s->numero_serie)
                    <p class="text-xs text-gray-400 mt-0.5">S/N: {{ $s->numero_serie }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Contacto</p>
                    <p class="text-gray-800">{{ $s->telefono ?? 'Sin teléfono' }}</p>
                    @if($s->email_contacto)
                    <p class="text-xs text-gray-400">{{ $s->email_contacto }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Creado</p>
                    <p class="text-gray-800">{{ $s->created_at?->format('d/m/Y') ?? '-' }}</p>
                    <p class="text-xs text-gray-400">{{ $s->created_at?->diffForHumans() ?? '' }}</p>
                </div>
            </div>
            <div class="px-5 pb-5">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Problema</p>
                <p class="text-sm text-gray-600">{{ $s->descripcion_problema }}</p>
                @if($s->accesorios_incluidos)
                <div class="mt-2 text-xs text-gray-400">
                    <span class="font-semibold">Accesorios:</span> {{ $s->accesorios_incluidos }}
                </div>
                @endif
                @if($s->direccion)
                <div class="mt-1 text-xs text-gray-400">
                    <span class="font-semibold">Dirección:</span> {{ $s->direccion }}
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <p class="text-gray-500 font-medium">No tienes solicitudes registradas</p>
            <a href="{{ route('servicios.create') }}" class="inline-block mt-3 text-sm text-blue-600 hover:text-blue-800 font-medium">Crear una solicitud →</a>
        </div>
        @endforelse
    </div>
</x-app-layout>
