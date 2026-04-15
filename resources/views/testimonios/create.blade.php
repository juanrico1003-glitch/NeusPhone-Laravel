<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#004080]">
            Dejar una Reseña
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">¡Queremos escucharte, {{ Auth::user()->nombres }}!</h3>
                    <p class="text-gray-600">Tu opinión nos ayuda a mejorar y guía a otros clientes en su proceso de compra con NeusPhone.</p>
                </div>

                <form method="POST" action="{{ route('testimonios.store') }}" class="space-y-6">
                    @csrf

                    <!-- Calificación -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-2">Calificación (Estrellas)</label>
                        <div class="flex items-center space-x-2">
                            <select name="calificacion" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-32" required>
                                <option value="5">5 Extras ⭐⭐⭐⭐⭐</option>
                                <option value="4">4 Estrellas ⭐⭐⭐⭐</option>
                                <option value="3">3 Estrellas ⭐⭐⭐</option>
                                <option value="2">2 Estrellas ⭐⭐</option>
                                <option value="1">1 Estrella ⭐</option>
                            </select>
                        </div>
                    </div>

                    <!-- Comentario -->
                    <div>
                        <label for="comentario" class="block font-medium text-sm text-gray-700 mb-2">Escribe tu testimonio</label>
                        <textarea id="comentario" name="comentario" rows="5" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-full" placeholder="Ej. El teléfono llegó rápido y en excelentes condiciones..." required></textarea>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="bg-[#004080] hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                            Publicar Reseña
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
