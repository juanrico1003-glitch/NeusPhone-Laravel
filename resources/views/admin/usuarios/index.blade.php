<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl">Usuarios</h2>
            <div class="flex gap-2 text-sm">
                <a href="{{ route('admin.usuarios.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">+ Nuevo usuario</a>
                <a href="{{ route('admin.exportar.usuarios') }}" class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-lg transition">Exportar Excel</a>
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">← Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="p-6">
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow p-4 border-l-4 border-blue-500">
                <p class="text-xs text-gray-500 uppercase">Total</p>
                <p class="text-xl font-bold text-blue-600">{{ $totalUsuarios }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-4 border-l-4 border-green-500">
                <p class="text-xs text-gray-500 uppercase">Activos</p>
                <p class="text-xl font-bold text-green-600">{{ $activos }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-4 border-l-4 border-purple-500">
                <p class="text-xs text-gray-500 uppercase">Nuevos este mes</p>
                <p class="text-xl font-bold text-purple-600">{{ $nuevosEsteMes }}</p>
            </div>
        </div>

        <form method="GET" class="mb-4">
            <div class="flex gap-2 max-w-md">
                <input type="text" name="buscar" placeholder="Buscar por nombre, email o cédula..."
                       value="{{ request('buscar') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">Buscar</button>
                @if(request('buscar'))
                    <a href="{{ route('admin.usuarios.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm transition">Limpiar</a>
                @endif
            </div>
        </form>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-3 rounded mb-4 text-sm">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left text-gray-500">
                            <th class="p-3 font-medium">ID</th>
                            <th class="p-3 font-medium">Nombre</th>
                            <th class="p-3 font-medium">Email</th>
                            <th class="p-3 font-medium">Cédula</th>
                            <th class="p-3 font-medium">Rol</th>
                            <th class="p-3 font-medium">Estado</th>
                            <th class="p-3 font-medium">Registro</th>
                            <th class="p-3 font-medium"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($usuarios as $u)
                        <tr class="hover:bg-gray-50 text-gray-700">
                            <td class="p-3 font-mono text-xs">{{ $u->id }}</td>
                            <td class="p-3 font-medium">{{ $u->nombres }} {{ $u->apellidos }}</td>
                            <td class="p-3">{{ $u->correo ?? '-' }}</td>
                            <td class="p-3">{{ $u->cedula ?? '-' }}</td>
                            <td class="p-3">
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $u->rol?->nombre === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $u->rol?->nombre ?? 'Sin rol' }}
                                </span>
                            </td>
                            <td class="p-3">
                                @if($u->estado)
                                    <span class="text-green-600 font-bold">Activo</span>
                                @else
                                    <span class="text-red-600 font-bold">Inactivo</span>
                                @endif
                            </td>
                            <td class="p-3 text-xs text-gray-400">{{ $u->created_at?->format('d/m/Y') ?? '-' }}</td>
                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.usuarios.edit', $u) }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">Editar</a>
                                    @if($u->id !== auth()->id())
                                        @if($u->estado)
                                        <form action="{{ route('admin.usuarios.destroy', $u) }}" method="POST" onsubmit="return confirm('¿Desactivar este usuario?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">Desactivar</button>
                                        </form>
                                        @else
                                        <form action="{{ route('admin.usuarios.activar', $u) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">Activar</button>
                                        </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
