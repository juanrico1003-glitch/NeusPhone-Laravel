<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Gestión de Servicios
        </h2>
    </x-slot>

    <div class="p-6">

        <!-- Filtro -->
        <form method="GET" class="mb-6 flex gap-3">
            <select name="estado" class="border rounded p-2">
                <option value="">Todos</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en_revision" {{ request('estado') == 'en_revision' ? 'selected' : '' }}>En proceso / Revisión</option>
                <option value="reparado" {{ request('estado') == 'reparado' ? 'selected' : '' }}>Reparado / Listo</option>
                <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Filtrar
            </button>
        </form>

        <!-- Tabla -->
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="p-3">Cliente</th>
                        <th class="p-3">Servicio</th>
                        <th class="p-3">Descripción</th>
                        <th class="p-3">Estado</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($solicitudes as $solicitud)
                        <tr class="border-t">
                            <td class="p-3">
                                {{ $solicitud->usuario->nombres }}
                            </td>

                            <td class="p-3">
                                {{ $solicitud->servicio->nombre }}
                            </td>

                            <td class="p-3">
                                {{ $solicitud->descripcion }}
                            </td>

                            <td class="p-3 font-semibold">
                                @php
                                    $estadosLabel = [
                                        'pendiente' => 'Pendiente',
                                        'en_revision' => 'En proceso / Revisión',
                                        'reparado' => 'Reparado / Listo',
                                        'entregado' => 'Entregado',
                                        'cancelado' => 'Cancelado'
                                    ];
                                @endphp
                                {{ $estadosLabel[$solicitud->estado] ?? ucfirst(str_replace('_', ' ', $solicitud->estado)) }}
                            </td>

                            <td class="p-3">
                                <form action="{{ route('admin.servicios.estado',$solicitud->id) }}" method="POST" class="flex gap-2">
                                    @csrf

                                    <select name="estado" class="border rounded p-1 text-sm">
                                        <option value="pendiente" {{ $solicitud->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="en_revision" {{ $solicitud->estado == 'en_revision' ? 'selected' : '' }}>En proceso / Revisión</option>
                                        <option value="reparado" {{ $solicitud->estado == 'reparado' ? 'selected' : '' }}>Reparado / Listo</option>
                                        <option value="entregado" {{ $solicitud->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                        <option value="cancelado" {{ $solicitud->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                    </select>

                                    <button class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                                        Actualizar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center">
                                No hay solicitudes
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
