<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4">
        <h1 class="text-6xl font-bold text-red-500 mb-4">500</h1>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Error del servidor</h2>
        <p class="text-gray-500 mb-6">Ocurrió un error inesperado. Por favor intenta de nuevo más tarde.</p>
        <a href="{{ url('/') }}" class="bg-[#004080] hover:bg-blue-800 text-white px-6 py-3 rounded-lg font-medium transition">Volver al inicio</a>
    </div>
</x-guest-layout>
