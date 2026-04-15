<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Solicitar Servicio de Mantenimiento
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-2xl p-6">

                <form method="POST" action="{{ route('servicios.store') }}">
                    @csrf

                    {{-- Seleccionar servicio --}}
                    <div class="mb-5">
                        <label class="block mb-2 font-semibold text-gray-700">
                            Tipo de servicio
                        </label>

                        <select name="servicio_id"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400"
                                required>

                            <option value="">Seleccione un servicio</option>

                            @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}">
                                    {{ $servicio->nombre }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Descripción del problema --}}
                    <div class="mb-5">
                        <label class="block mb-2 font-semibold text-gray-700">
                            Descripción del problema
                        </label>

                        <textarea name="descripcion_problema"
                                  rows="5"
                                  class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400"
                                  placeholder="Describe el problema que presenta el equipo..."
                                  required></textarea>
                    </div>

                    {{-- Botón --}}
                    <div class="text-right">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                            Enviar solicitud
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
