<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Pedidos realizados
        </h2>
    </x-slot>

    <div class="p-6">

        <div class="flex gap-2 mb-4">
            <a href="{{ route('admin.exportar.pedidos') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition">
                Exportar CSV
            </a>
            <a href="{{ route('admin.exportar.pedidos.excel') }}" class="inline-block bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-lg text-sm transition">
                Exportar Excel
            </a>
        </div>

        <table class="w-full border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2">Pedido</th>
                    <th class="p-2">Cliente</th>
                    <th class="p-2">Total</th>
                    <th class="p-2">Estado</th>
                    <th class="p-2">Fecha</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pedidos as $pedido)
                    <tr class="border-t">
                        <td class="p-2">#{{ $pedido->id }}</td>

                        <td class="p-2">
                            {{ $pedido->usuario->nombres ?? '' }}
                        </td>

                        <td class="p-2">
                            ${{ number_format($pedido->total, 0, ',', '.') }}
                        </td>

                        <td class="p-2">
                            {{ $pedido->estado }}
                        </td>

                        <td class="p-2">
                            {{ $pedido->created_at }}
                        </td>

                        <td class="p-2">
                            <a href="{{ route('admin.pedidos.show', $pedido->id) }}"
                               class="px-3 py-1 bg-blue-600 text-white rounded">
                                Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        <div class="mt-4">
            {{ $pedidos->links() }}
        </div>

    </div>
</x-app-layout>
