<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600">
            Mis solicitudes de mantenimiento
        </h2>
    </x-slot>

    <div class="bg-gray-100 py-8">
        <div class="max-w-5xl mx-auto">

            <a href="{{ route('servicios.create') }}"
               class="mb-6 inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition">
                Nueva solicitud
            </a>

            <div class="bg-white shadow-md rounded-2xl p-6">

                @forelse($servicios as $servicio)

                    <div class="border-b py-4">

                        <p class="font-semibold">
                            {{ ucfirst($servicio->tipo_equipo) }}
                            {{ $servicio->marca }} {{ $servicio->modelo }}
                        </p>

                        <p class="text-gray-600 text-sm">
                            {{ $servicio->descripcion_problema }}
                        </p>

                        <p class="mt-2">
                            Estado:
                            <span class="font-bold text-blue-600">
                                {{ ucfirst(str_replace('_', ' ', $servicio->estado)) }}
                            </span>
                        </p>

                        <p class="text-gray-400 text-sm">
                            {{ $servicio->created_at }}
                        </p>

                    </div>

                @empty
                    <p>No tienes solicitudes registradas.</p>
                @endforelse

            </div>

        </div>
    </div>

</x-app-layout>
