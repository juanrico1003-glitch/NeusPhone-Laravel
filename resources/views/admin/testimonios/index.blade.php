<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Gestión de Reseñas de Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-4 border">ID</th>
                            <th class="p-4 border">Cliente</th>
                            <th class="p-4 border">Calificación</th>
                            <th class="p-4 border text-center">Estado (Público)</th>
                            <th class="p-4 border">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonios as $test)
                        <tr class="border hover:bg-gray-50">
                            <td class="p-4">{{ $test->id }}</td>
                            <td class="p-4 font-bold">{{ $test->usuario->nombres ?? 'Desconocido' }}</td>
                            <td class="p-4 text-yellow-500 font-bold">
                                {{ $test->calificacion }} ⭐
                            </td>
                            <td class="p-4 text-center">
                                @if($test->estado == 1)
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Publicado</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Oculto</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <form action="{{ route('admin.testimonios.toggle', $test->id) }}" method="POST">
                                    @csrf
                                    @if($test->estado == 1)
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-sm">Quitar</button>
                                    @else
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded text-sm">Publicar</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="p-4 text-gray-600 text-sm italic bg-gray-50 border-b">
                                "{{ $test->comentario }}"
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">No hay testimonios registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
