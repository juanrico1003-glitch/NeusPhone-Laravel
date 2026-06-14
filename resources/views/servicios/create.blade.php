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

        <div x-data="servicioForm()" x-init="initForm()">
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
                            <select name="servicio_id" required x-model="form.servicio_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                            <select name="tipo_equipo" required x-model="form.tipo_equipo" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccione...</option>
                                <option value="celular">Celular / Smartphone</option>
                                <option value="tablet">Tablet</option>
                                <option value="laptop">Laptop / Notebook</option>
                                <option value="pc_escritorio">PC de Escritorio</option>
                                <option value="consola">Consola / Videojuegos</option>
                                <option value="impresora">Impresora</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Marca *</label>
                            <input type="text" name="marca_equipo" x-model="form.marca_equipo" required placeholder="Ej: Samsung, HP, Apple..."
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Modelo</label>
                            <input type="text" name="modelo_equipo" x-model="form.modelo_equipo" placeholder="Ej: Galaxy S23, Pavilion 15..."
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Número de serie</label>
                        <input type="text" name="numero_serie" x-model="form.numero_serie" placeholder="Si lo conoces, nos ayuda a identificar el equipo"
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
                        <textarea name="descripcion_problema" x-model="form.descripcion_problema" rows="4" required
                                  placeholder="Describe detalladamente el problema: ¿qué falla?, ¿desde cuándo?, ¿hay algún mensaje de error?, ¿qué has intentado?"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div class="mt-4">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Accesorios incluidos</label>
                        <textarea name="accesorios_incluidos" x-model="form.accesorios_incluidos" rows="2"
                                  placeholder="Ej: Cargador, funda, audífonos, cable USB — lo que entregas junto al equipo"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
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
                            <input type="tel" name="telefono" x-model="form.telefono" required
                                   placeholder="Ej: 3001234567"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Correo electrónico</label>
                            <input type="email" name="email_contacto" x-model="form.email_contacto"
                                   placeholder="Correo para notificaciones"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Dirección</label>
                        <input type="text" name="direccion" x-model="form.direccion"
                               placeholder="Dirección de recogida o contacto (opcional)"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs text-gray-400 text-center sm:text-left">* Campos obligatorios</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a :href="whatsappUrl"
                           target="_blank"
                           class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg text-sm transition shadow-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Enviar por WhatsApp
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg text-sm transition shadow-sm">
                            Enviar solicitud
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    function servicioForm() {
        return {
            form: {
                servicio_id: '',
                tipo_equipo: '',
                marca_equipo: '',
                modelo_equipo: '',
                numero_serie: '',
                descripcion_problema: '',
                accesorios_incluidos: '',
                telefono: '{{ old("telefono", $user->telefono ?? "") }}',
                email_contacto: '{{ old("email_contacto", $user->correo ?? "") }}',
                direccion: '',
            },
            initForm() {
                // Preservar old() values si hay errores de validacion
                const old = @json(old());
                if (old && Object.keys(old).length > 0) {
                    Object.assign(this.form, old);
                }
            },
            get whatsappUrl() {
                const f = this.form;
                const servicioNombre = document.querySelector('select[name="servicio_id"]')?.selectedOptions[0]?.text || f.servicio_id;
                const tipoLabels = { celular: 'Celular', tablet: 'Tablet', laptop: 'Laptop', pc_escritorio: 'PC Escritorio', consola: 'Consola', impresora: 'Impresora', otro: 'Otro' };
                const tipoEquipo = tipoLabels[f.tipo_equipo] || f.tipo_equipo || 'No especificado';

                let msg = '📱 *Nueva solicitud de servicio técnico*';
                msg += '\n\n═══════════════════════';
                msg += '\n🔧 *Servicio:* ' + (servicioNombre || 'No especificado');
                msg += '\n📋 *Tipo de equipo:* ' + tipoEquipo;
                msg += '\n🏷️ *Marca:* ' + (f.marca_equipo || 'No especificada');
                msg += '\n📝 *Modelo:* ' + (f.modelo_equipo || 'No especificado');
                if (f.numero_serie) msg += '\n🔢 *N/S:* ' + f.numero_serie;
                msg += '\n\n═══════════════════════';
                msg += '\n❓ *Problema:*';
                msg += '\n' + (f.descripcion_problema || 'No especificado');
                if (f.accesorios_incluidos) {
                    msg += '\n\n📦 *Accesorios:* ' + f.accesorios_incluidos;
                }
                msg += '\n\n═══════════════════════';
                msg += '\n👤 *Contacto:*';
                msg += '\n📞 Tel: ' + (f.telefono || 'No especificado');
                if (f.email_contacto) msg += '\n📧 Email: ' + f.email_contacto;
                if (f.direccion) msg += '\n📍 Dirección: ' + f.direccion;
                msg += '\n\n═══════════════════════';
                msg += '\n_Generado desde NeusPhone Web_';

                const phone = '573004060632';
                return 'https://wa.me/' + phone + '?text=' + encodeURIComponent(msg);
            }
        };
    }
    </script>
</x-app-layout>
