<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#004080] leading-tight flex items-center">
            👋 Hola, {{ Auth::user()->nombres }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50/50 min-h-[80vh]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- TARJETAS DE RESUMEN -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                
                <div class="bg-white rounded-3xl shadow-lg p-6 border-l-4 border-blue-500 hover:-translate-y-1 transition transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 font-medium">Mis Pedidos</p>
                            <h3 class="text-4xl font-extrabold mt-2 text-blue-600">
                                {{ $pedidosCount ?? 0 }}
                            </h3>
                        </div>
                        <div class="text-5xl opacity-20">📦</div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-lg p-6 border-l-4 border-orange-500 hover:-translate-y-1 transition transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 font-medium">Servicios Técnicos</p>
                            <h3 class="text-4xl font-extrabold mt-2 text-orange-500">
                                {{ $serviciosCount ?? 0 }}
                            </h3>
                        </div>
                        <div class="text-5xl opacity-20">🔧</div>
                    </div>
                </div>

            </div>

            <!-- ACCESOS RÁPIDOS -->
            <h3 class="text-xl font-bold text-gray-800 mb-6">Accesos Rápidos</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                <a href="{{ route('pedidos.index') }}"
                   class="bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white rounded-3xl shadow-xl p-8 text-center transition transform hover:scale-105">
                    <div class="text-4xl mb-4">🛍️</div>
                    <h3 class="text-xl font-bold">Mis Pedidos</h3>
                    <p class="mt-2 text-sm text-blue-100">Rastrea tus compras e historial</p>
                </a>

                <a href="{{ route('servicios.index') }}"
                   class="bg-gradient-to-br from-orange-500 to-orange-700 hover:from-orange-600 hover:to-orange-800 text-white rounded-3xl shadow-xl p-8 text-center transition transform hover:scale-105">
                    <div class="text-4xl mb-4">📱</div>
                    <h3 class="text-xl font-bold">Soporte Técnico</h3>
                    <p class="mt-2 text-sm text-orange-100">Estado de tus reparaciones</p>
                </a>

                <a href="{{ route('testimonios.create') }}"
                   class="bg-gradient-to-br from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 text-white rounded-3xl shadow-xl p-8 text-center transition transform hover:scale-105">
                    <div class="text-4xl mb-4">⭐</div>
                    <h3 class="text-xl font-bold">Dejar Reseña</h3>
                    <p class="mt-2 text-sm text-yellow-50">Cuéntanos tu experiencia</p>
                </a>

            </div>

            <!-- SECCIÓN EXTRA DE RECOMENDACIÓN -->
            <div class="bg-white rounded-3xl shadow p-8 text-center border border-gray-100">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    🤖
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">¿Necesitas ayuda para escoger tu próximo equipo?</h3>
                <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                    Recuerda que nuestro asistente virtual inteligente está disponible en la esquina inferior derecha de nuestra tienda en cualquier momento para analizar tus necesidades y recomendarte el mejor dispositivo de nuestro catálogo.
                </p>
                <a href="{{ route('tienda') }}" class="px-8 py-3 bg-[#004080] text-white rounded-full font-bold hover:bg-blue-800 hover:shadow-lg transition">
                    Volver a la Tienda
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
