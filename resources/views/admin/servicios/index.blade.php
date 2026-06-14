<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Gestión de servicios técnicos</h2>
    </x-slot>

    <div class="p-4 sm:p-6 max-w-7xl mx-auto space-y-5">

        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-3 rounded-lg text-sm">{{ session('success') }}</div>
        @endif

        <div class="flex flex-wrap items-center gap-2 mb-4">
            <a href="{{ route('admin.exportar.servicios') }}" class="inline-block bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm transition">
                Exportar Excel
            </a>
        </div>

        <form method="GET" class="flex flex-wrap gap-2">
            <select name="estado" class="border border-gray-300 rounded-lg pl-3 pr-7 py-2 text-sm focus:ring-2 focus:ring-blue-500 appearance-none" style="background-image: url('data:image/svg+xml;charset=utf-8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22gray%22><path d=%22M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z%22/></svg>'); background-repeat: no-repeat; background-position: right 0.4rem center; background-size: 1rem;">
                <option value="">Todos los estados</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en_revision" {{ request('estado') == 'en_revision' ? 'selected' : '' }}>En revisión</option>
                <option value="reparado" {{ request('estado') == 'reparado' ? 'selected' : '' }}>Reparado</option>
                <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">Filtrar</button>
            @if(request('estado'))
            <a href="{{ route('admin.servicios.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm transition">Limpiar</a>
            @endif
        </form>

        @forelse($solicitudes as $s)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Cabecera --}}
            <div class="flex items-center justify-between px-5 py-3 bg-gray-50/50 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-mono font-bold text-gray-400">#{{ $s->id }}</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $s->servicio?->nombre ?? 'Sin servicio' }}</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide
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
                <div class="text-xs text-gray-400">{{ $s->created_at?->format('d/m/Y h:i A') ?? '-' }}</div>
            </div>

            <div class="p-5 grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Columna 1: Cliente --}}
                <div>
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Cliente
                    </h4>
                    <p class="text-sm font-semibold text-gray-800">{{ $s->usuario?->nombres ?? 'Eliminado' }} {{ $s->usuario?->apellidos ?? '' }}</p>
                    <p class="text-xs text-gray-400">{{ $s->usuario?->correo ?? '' }}</p>
                    @if($s->usuario?->cedula)
                    <p class="text-xs text-gray-400">CC: {{ $s->usuario->cedula }}</p>
                    @endif
                </div>

                {{-- Columna 2: Contacto proporcionado --}}
                <div>
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Contacto
                    </h4>
                    <p class="text-sm text-gray-800">
                        <span class="font-medium">Tel:</span>
                        <a href="tel:{{ $s->telefono }}" class="text-blue-600 hover:underline">{{ $s->telefono ?? '-' }}</a>
                    </p>
                    @if($s->email_contacto)
                    <p class="text-sm text-gray-800">
                        <span class="font-medium">Email:</span>
                        <a href="mailto:{{ $s->email_contacto }}" class="text-blue-600 hover:underline">{{ $s->email_contacto }}</a>
                    </p>
                    @endif
                    @if($s->direccion)
                    <p class="text-xs text-gray-500 mt-1"><span class="font-medium">Dirección:</span> {{ $s->direccion }}</p>
                    @endif
                </div>

                {{-- Columna 3: Equipo --}}
                <div>
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Equipo
                    </h4>
                    <p class="text-sm font-medium text-gray-800">
                        @if($s->tipo_equipo){{ ucfirst($s->tipo_equipo) }}@else—@endif
                    </p>
                    <p class="text-xs text-gray-500">
                        @if($s->marca_equipo){{ $s->marca_equipo }}@endif
                        @if($s->modelo_equipo) · {{ $s->modelo_equipo }}@endif
                    </p>
                    @if($s->numero_serie)
                    <p class="text-xs text-gray-400 mt-0.5">S/N: {{ $s->numero_serie }}</p>
                    @endif
                </div>
            </div>

            {{-- Descripción del problema --}}
            <div class="px-5 pb-2">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1.5">Problema reportado</h4>
                <p class="text-sm text-gray-600 bg-gray-50 rounded-lg p-3">{{ $s->descripcion_problema }}</p>
                @if($s->accesorios_incluidos)
                <div class="mt-2 text-xs text-gray-500">
                    <span class="font-semibold">Accesorios incluidos:</span> {{ $s->accesorios_incluidos }}
                </div>
                @endif
            </div>

            {{-- Acción: cambiar estado + contacto --}}
            <div class="px-5 py-3 border-t border-gray-50 bg-gray-50/30 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                <form action="{{ route('admin.servicios.estado', $s->id) }}" method="POST" class="flex flex-wrap items-center gap-3">
                    @csrf
                    <label class="text-xs font-semibold text-gray-500">Cambiar estado:</label>
                    <select name="estado" class="border border-gray-300 rounded-lg pl-2.5 pr-7 py-1.5 text-xs focus:ring-2 focus:ring-blue-500 appearance-none" style="background-image: url('data:image/svg+xml;charset=utf-8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22gray%22><path d=%22M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z%22/></svg>'); background-repeat: no-repeat; background-position: right 0.4rem center; background-size: 1rem;">
                        <option value="pendiente" {{ $s->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_revision" {{ $s->estado == 'en_revision' ? 'selected' : '' }}>En revisión</option>
                        <option value="reparado" {{ $s->estado == 'reparado' ? 'selected' : '' }}>Reparado</option>
                        <option value="entregado" {{ $s->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                        <option value="cancelado" {{ $s->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs transition">Actualizar</button>
                </form>
                <div class="flex items-center gap-2">
                    @php
                        $waPhone = preg_replace('/[^0-9]/', '', $s->telefono ?? '');
                        if ($waPhone && !str_starts_with($waPhone, '57')) {
                            $waPhone = '57' . $waPhone;
                        }
                        $waMsg = 'Hola, soy de NeusPhone.%0D%0A%0D%0A';
                        $waMsg .= 'Te escribo respecto a tu solicitud de servicio *%23' . ($s->id ?? '') . '*';
                        if ($s->servicio?->nombre) $waMsg .= ' para *' . urlencode($s->servicio->nombre) . '*';
                        $waMsg .= '.%0D%0A%0D%0A';
                        if ($s->marca_equipo) {
                            $waMsg .= '*Equipo:* ' . urlencode($s->marca_equipo);
                            if ($s->modelo_equipo) $waMsg .= ' ' . urlencode($s->modelo_equipo);
                            $waMsg .= '%0D%0A';
                        }
                        if ($s->descripcion_problema) {
                            $waMsg .= '*Problema:* ' . urlencode(\Illuminate\Support\Str::limit($s->descripcion_problema, 120)) . '%0D%0A%0D%0A';
                        }
                        $waMsg .= 'Quedo atento para coordinar la revisi%C3%B3n y gestionar el proceso.';
                    @endphp
                    @if($waPhone)
                    <a href="https://wa.me/{{ $waPhone }}?text={{ $waMsg }}" target="_blank"
                       class="flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    @endif
                    @if($s->email_contacto)
                    @php
                        $emailSubj = 'NeusPhone - Solicitud de servicio #' . $s->id;
                        $emailBody = 'Hola, soy de NeusPhone.' . "\n\n";
                        $emailBody .= 'Te escribo respecto a tu solicitud de servicio #' . $s->id;
                        if ($s->servicio?->nombre) $emailBody .= ' para ' . $s->servicio->nombre;
                        $emailBody .= '.' . "\n\n";
                        if ($s->marca_equipo) {
                            $emailBody .= 'Equipo: ' . $s->marca_equipo;
                            if ($s->modelo_equipo) $emailBody .= ' ' . $s->modelo_equipo;
                            $emailBody .= "\n";
                        }
                        if ($s->descripcion_problema) {
                            $emailBody .= 'Problema: ' . \Illuminate\Support\Str::limit($s->descripcion_problema, 200) . "\n\n";
                        }
                        $emailBody .= 'Quedo atento para coordinar la revisión y gestionar el proceso.';
                    @endphp
                    <a href="mailto:{{ $s->email_contacto }}?subject={{ urlencode($emailSubj) }}&body={{ urlencode($emailBody) }}" target="_blank"
                       class="flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Email
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <p class="text-gray-500 font-medium">No hay solicitudes de servicio</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4 px-6 pb-6">
        {{ $solicitudes->links() }}
    </div>
</x-app-layout>
