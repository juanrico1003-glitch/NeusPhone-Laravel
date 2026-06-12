<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Solicitar servicio técnico</h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 max-w-4xl mx-auto">
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('servicios.store') }}" class="space-y-6">
            @csrf

            {{-- Sección: Tipo de servicio --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Servicio solicitado
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Tipo de servicio *</label>
                        <select name="servicio_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione un servicio</option>
                            @foreach($servicios as $s)
                            <option value="{{ $s->id }}" {{ old('servicio_id') == $s->id ? 'selected' : '' }}>{{ $s->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Sección: Información del equipo --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Información del equipo
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Tipo de equipo *</label>
                        <select name="tipo_equipo" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione...</option>
                            <option value="celular" {{ old('tipo_equipo') == 'celular' ? 'selected' : '' }}>Celular / Smartphone</option>
                            <option value="tablet" {{ old('tipo_equipo') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="laptop" {{ old('tipo_equipo') == 'laptop' ? 'selected' : '' }}>Laptop / Notebook</option>
                            <option value="pc_escritorio" {{ old('tipo_equipo') == 'pc_escritorio' ? 'selected' : '' }}>PC de Escritorio</option>
                            <option value="consola" {{ old('tipo_equipo') == 'consola' ? 'selected' : '' }}>Consola / Videojuegos</option>
                            <option value="impresora" {{ old('tipo_equipo') == 'impresora' ? 'selected' : '' }}>Impresora</option>
                            <option value="otro" {{ old('tipo_equipo') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Marca *</label>
                        <input type="text" name="marca_equipo" value="{{ old('marca_equipo') }}" required placeholder="Ej: Samsung, HP, Apple..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Modelo</label>
                        <input type="text" name="modelo_equipo" value="{{ old('modelo_equipo') }}" placeholder="Ej: Galaxy S23, Pavilion 15..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Número de serie</label>
                    <input type="text" name="numero_serie" value="{{ old('numero_serie') }}" placeholder="Si lo conoces, nos ayuda a identificar el equipo"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- Sección: Descripción del problema --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Descripción del problema
                </h3>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">¿Qué le ocurre al equipo? *</label>
                    <textarea name="descripcion_problema" rows="4" required
                              placeholder="Describe detalladamente el problema: ¿qué falla?, ¿desde cuándo?, ¿hay algún mensaje de error?, ¿qué has intentado?"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('descripcion_problema') }}</textarea>
                </div>
                <div class="mt-4">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Accesorios incluidos</label>
                    <textarea name="accesorios_incluidos" rows="2"
                              placeholder="Ej: Cargador, funda, audífonos, cable USB — lo que entregas junto al equipo"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('accesorios_incluidos') }}</textarea>
                </div>
            </div>

            {{-- Sección: Información de contacto --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Información de contacto
                </h3>
                <p class="text-xs text-gray-400 mb-4">Para que podamos comunicarnos contigo sobre el estado de tu servicio</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Teléfono de contacto *</label>
                        <input type="tel" name="telefono" value="{{ old('telefono', $user->telefono ?? '') }}" required
                               placeholder="Ej: 3001234567"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Correo electrónico</label>
                        <input type="email" name="email_contacto" value="{{ old('email_contacto', $user->correo ?? '') }}"
                               placeholder="Correo para notificaciones"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion') }}"
                           placeholder="Dirección de recogida o contacto (opcional)"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- Botón --}}
            <div class="flex items-center justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs text-gray-400">* Campos obligatorios</p>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg text-sm transition shadow-sm">
                    Enviar solicitud
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
