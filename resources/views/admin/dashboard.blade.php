<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Panel Administrativo
        </h2>
    </x-slot>

    <div class="p-6">

        <!-- TARJETAS PRINCIPALES -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-500">
                <p class="text-gray-500 text-sm">Productos activos</p>
                <h3 class="text-3xl font-bold mt-2 text-blue-600">
                    {{ $productosActivos }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-red-500">
                <p class="text-gray-500 text-sm">Sin stock</p>
                <h3 class="text-3xl font-bold mt-2 text-red-600">
                    {{ $sinStock }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-yellow-400">
                <p class="text-gray-500 text-sm">Pedidos pendientes</p>
                <h3 class="text-3xl font-bold mt-2 text-yellow-500">
                    {{ $pendientes }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-500">
                <p class="text-gray-500 text-sm">Total vendido</p>
                <h3 class="text-3xl font-bold mt-2 text-green-600">
                    ${{ number_format($ventas, 0, ',', '.') }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-purple-500">
                <p class="text-gray-500 text-sm">Servicios pendientes</p>
                <h3 class="text-3xl font-bold mt-2 text-purple-600">
                    {{ $serviciosPendientes }}
                </h3>
            </div>

        </div>

        <!-- ACCESOS RÁPIDOS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

            <a href="{{ route('admin.productos.index') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white rounded-2xl shadow-md p-6 text-center transition">
                <h3 class="text-xl font-bold">Gestionar Productos</h3>
                <p class="mt-2 text-sm">Crear, editar y administrar inventario</p>
            </a>

            <a href="{{ route('admin.testimonios') }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-2xl shadow-md p-6 text-center transition">
                <h3 class="text-xl font-bold">Gestionar Reseñas</h3>
                <p class="mt-2 text-sm">Aprobar u ocultar testimonios</p>
            </a>

            <a href="{{ route('admin.pedidos.index') }}"
               class="bg-green-600 hover:bg-green-700 text-white rounded-2xl shadow-md p-6 text-center transition">
                <h3 class="text-xl font-bold">Gestionar Pedidos</h3>
                <p class="mt-2 text-sm">Revisar y actualizar estados</p>
            </a>

            <a href="{{ route('admin.servicios.index') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white rounded-2xl shadow-md p-6 text-center transition">
                <h3 class="text-xl font-bold">Gestionar Servicios</h3>
                <p class="mt-2 text-sm">Solicitudes de mantenimiento</p>
            </a>

        </div>

    </div>

</x-app-layout>
