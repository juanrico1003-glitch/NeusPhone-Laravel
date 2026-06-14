<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4">
        <h1 class="text-6xl font-bold text-red-500 mb-4">403</h1>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Acceso denegado</h2>
        <p class="text-gray-500 mb-6">No tienes permiso para acceder a esta página.</p>
        <a href="{{ url('/') }}" class="bg-[#004080] hover:bg-blue-800 text-white px-6 py-3 rounded-lg font-medium transition">Volver al inicio</a>
    </div>
</x-guest-layout>
