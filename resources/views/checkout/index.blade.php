<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl md:text-3xl text-gray-800">
            Datos de Envío y Facturación
        </h2>
    </x-slot>

    <div class="py-6 md:py-8 max-w-7xl mx-auto">
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                <p class="font-bold mb-1">Por favor corrige los siguientes errores:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Formulario de Envío (8 columnas en desktop) -->
            <div class="lg:col-span-7 xl:col-span-8 bg-white shadow-md rounded-2xl p-6 md:p-8 border border-blue-100">
                <h3 class="text-xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-100">
                    Información de Envío y Contacto
                </h3>

                <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form">
                    @csrf

                    <!-- Datos Personales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block mb-2 font-semibold text-gray-700 text-sm">
                                Nombre completo
                            </label>
                            <input type="text" name="nombre_contacto" 
                                   value="{{ old('nombre_contacto', $ultimoEnvio->nombre_contacto ?? trim(($usuario->nombres ?? '') . ' ' . ($usuario->apellidos ?? ''))) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" 
                                   required placeholder="Ej. Juan Pérez">
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700 text-sm">
                                Correo electrónico
                            </label>
                            <input type="email" name="correo_contacto" 
                                   value="{{ old('correo_contacto', $ultimoEnvio->correo_contacto ?? $usuario->correo ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" 
                                   required placeholder="Ej. juan@correo.com">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block mb-2 font-semibold text-gray-700 text-sm">
                                Cédula / Documento de identidad
                            </label>
                            <input type="text" name="cedula_contacto" 
                                   value="{{ old('cedula_contacto', $ultimoEnvio->cedula_contacto ?? $usuario->cedula ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" 
                                   required placeholder="Ej. 10203040">
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700 text-sm">
                                Número de teléfono
                            </label>
                            <input type="tel" name="telefono_contacto" 
                                   value="{{ old('telefono_contacto', $ultimoEnvio->telefono_contacto ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" 
                                   required placeholder="Ej. 3001234567">
                        </div>
                    </div>

                    <hr class="my-6 border-gray-100">

                    <!-- Dirección de Envío -->
                    <h4 class="text-lg font-bold text-gray-800 mb-4">Dirección de Entrega</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block mb-2 font-semibold text-gray-700 text-sm">
                                Departamento
                            </label>
                            <select name="departamento" id="departamento"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" 
                                    required>
                                <option value="">Cargando departamentos...</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold text-gray-700 text-sm">
                                Municipio / Ciudad
                            </label>
                            <select name="municipio" id="municipio"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" 
                                    disabled required>
                                <option value="">Selecciona un departamento primero</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block mb-2 font-semibold text-gray-700 text-sm">
                            Dirección de envío (Calle, Avenida, Barrio)
                        </label>
                        <input type="text" name="direccion" 
                               value="{{ old('direccion', $ultimoEnvio->direccion ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" 
                               required placeholder="Ej. Calle 10 # 4-25, Barrio Centro">
                    </div>

                    <!-- Datos adicionales del lugar -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block mb-2 font-semibold text-gray-700 text-sm">
                                Tipo de vivienda / Establecimiento
                            </label>
                            <select name="tipo_lugar" id="tipo_lugar"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" 
                                    required>
                                <option value="casa" {{ old('tipo_lugar', $ultimoEnvio->tipo_lugar ?? '') == 'casa' ? 'selected' : '' }}>Casa</option>
                                <option value="apartamento" {{ old('tipo_lugar', $ultimoEnvio->tipo_lugar ?? '') == 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                                <option value="oficina_empresa" {{ old('tipo_lugar', $ultimoEnvio->tipo_lugar ?? '') == 'oficina_empresa' ? 'selected' : '' }}>Oficina / Empresa</option>
                                <option value="edificio" {{ old('tipo_lugar', $ultimoEnvio->tipo_lugar ?? '') == 'edificio' ? 'selected' : '' }}>Edificio</option>
                                <option value="otro" {{ old('tipo_lugar', $ultimoEnvio->tipo_lugar ?? '') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>

                        <div>
                            <label id="nombre_lugar_label" class="block mb-2 font-semibold text-gray-700 text-sm">
                                Nombre de la casa / Condominio <span class="text-xs text-gray-400 font-normal">(opcional)</span>
                            </label>
                            <input type="text" name="nombre_lugar" id="nombre_lugar"
                                   value="{{ old('nombre_lugar', $ultimoEnvio->nombre_lugar ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" 
                                   placeholder="Ej. Casa 15, Condominio El Roble">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 text-sm">
                            Indicaciones adicionales de entrega (opcional)
                        </label>
                        <input type="text" name="detalles_envio" 
                               value="{{ old('detalles_envio', $ultimoEnvio->detalles_envio ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" 
                               placeholder="Ej. Casa de 2 pisos, dejar en recepción a nombre de María">
                    </div>

                    <div class="mt-8">
                        <button type="submit" 
                                class="w-full bg-[#004080] hover:bg-[#003366] text-white font-bold px-6 py-4 rounded-xl shadow-lg transition transform hover:-translate-y-0.5 active:translate-y-0 text-center">
                            ✓ Confirmar datos y Proceder al pago
                        </button>
                    </div>

                </form>
            </div>

            <!-- Resumen de Compra (4 columnas en desktop) -->
            <div class="lg:col-span-5 xl:col-span-4 flex flex-col gap-6">
                <div class="bg-white shadow-md rounded-2xl p-6 border border-blue-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">
                        Resumen del Pedido
                    </h3>
                    
                    <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto pr-1">
                        @php $subtotal = 0; @endphp
                        @foreach($carrito as $id => $item)
                            @php $subtotal += $item['precio'] * $item['cantidad']; @endphp
                            <div class="py-3 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0 flex items-center justify-center">
                                        <img src="{{ asset('productos/'.$item['imagen']) }}" alt="{{ $item['nombre'] }}" class="object-contain w-10 h-10">
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-semibold text-sm text-gray-800 truncate max-w-[150px] md:max-w-[200px]">
                                            {{ $item['nombre'] }}
                                        </h4>
                                        <p class="text-xs text-gray-500">Cantidad: {{ $item['cantidad'] }}</p>
                                    </div>
                                </div>
                                <span class="font-semibold text-sm text-gray-700">
                                    ${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-4 mt-4 space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">${{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if(session('cupon_descuento'))
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-green-600">Cupón ({{ session('cupon_codigo') }}):</span>
                            <span class="font-medium text-green-600">-${{ number_format(session('cupon_descuento'), 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center text-sm" id="envio-row">
                            <span class="text-gray-600">Envío:</span>
                            <span id="envio-monto" class="font-medium">
                                @if($costoEnvio > 0)
                                    ${{ number_format($costoEnvio, 0, ',', '.') }}
                                @else
                                    <span class="text-green-600 font-semibold">Gratis</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                            <span class="text-gray-800 font-bold text-base">Total a pagar:</span>
                            <span id="total-pagar" class="text-xl md:text-2xl font-bold text-green-600">
                                ${{ number_format(max(0, ($subtotal - (session('cupon_descuento') ?? 0) + $costoEnvio)), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('carrito.index') }}" 
                       class="block w-full text-center mt-6 text-sm text-blue-600 hover:text-blue-800 font-semibold transition">
                        ← Editar Carrito
                    </a>
                </div>

                {{-- Cupón de descuento --}}
                <div class="bg-white shadow-md rounded-2xl p-6 border border-blue-100">
                    <h3 class="text-sm font-bold text-gray-800 mb-3">¿Tienes un cupón?</h3>
                    @if(session('cupon_codigo'))
                        <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-lg p-3">
                            <div>
                                <span class="text-sm font-semibold text-green-700">{{ session('cupon_codigo') }}</span>
                                <span class="text-xs text-green-600 ml-2">Descuento aplicado</span>
                            </div>
                            <form method="POST" action="{{ route('checkout.cupon.remover') }}">
                                @csrf
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Remover</button>
                            </form>
                        </div>
                    @else
                        <form method="POST" action="{{ route('checkout.cupon') }}" class="flex gap-2">
                            @csrf
                            <input type="text" name="codigo" placeholder="Ingresa el código"
                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Aplicar</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Script de Departamentos y Municipios -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deptoSelect = document.getElementById('departamento');
            const muniSelect = document.getElementById('municipio');

            // Fallback de departamentos y ciudades principales de Colombia en caso de fallo de red
            const fallbackData = [
                {
                    "departamento": "Antioquia",
                    "ciudades": ["Medellín", "Bello", "Envigado", "Itagüí", "Rionegro", "Sabaneta", "Caldas", "Copacabana", "La Estrella", "Marinilla", "Apartadó", "Caucasia", "Turbo"]
                },
                {
                    "departamento": "Bogotá D.C.",
                    "ciudades": ["Bogotá D.C."]
                },
                {
                    "departamento": "Valle del Cauca",
                    "ciudades": ["Cali", "Buenaventura", "Palmira", "Tuluá", "Yumbo", "Cartago", "Buga", "Jamundí", "Florida", "Pradera"]
                },
                {
                    "departamento": "Atlántico",
                    "ciudades": ["Barranquilla", "Soledad", "Malambo", "Sabanalarga", "Baranoa", "Puerto Colombia"]
                },
                {
                    "departamento": "Bolívar",
                    "ciudades": ["Cartagena de Indias", "Magangué", "Turbaco", "Arjona", "El Carmen de Bolívar"]
                },
                {
                    "departamento": "Santander",
                    "ciudades": ["Bucaramanga", "Floridablanca", "Girón", "Piedecuesta", "Barrancabermeja", "San Gil", "Socorro"]
                },
                {
                    "departamento": "Cundinamarca",
                    "ciudades": ["Soacha", "Fusagasugá", "Facatativá", "Chía", "Zipaquirá", "Girardot", "Mosquera", "Madrid", "Funza", "Cajicá", "Tocancipá"]
                },
                {
                    "departamento": "Norte de Santander",
                    "ciudades": ["Cúcuta", "Ocaña", "Villa del Rosario", "Los Patios", "Pamplona"]
                },
                {
                    "departamento": "Risaralda",
                    "ciudades": ["Pereira", "Dosquebradas", "Santa Rosa de Cabal", "La Virginia"]
                },
                {
                    "departamento": "Caldas",
                    "ciudades": ["Manizales", "La Dorada", "Chinchiná", "Riosucio", "Villamaría"]
                },
                {
                    "departamento": "Quindío",
                    "ciudades": ["Armenia", "Calarcá", "Tebaida", "Montenegro", "Quimbaya"]
                },
                {
                    "departamento": "Tolima",
                    "ciudades": ["Ibagué", "Espinal", "Melgar", "Mariquita", "Líbano", "Flandes"]
                },
                {
                    "departamento": "Huila",
                    "ciudades": ["Neiva", "Pitalito", "Garzón", "La Plata"]
                },
                {
                    "departamento": "Meta",
                    "ciudades": ["Villavicencio", "Acacías", "Granada", "Puerto López"]
                },
                {
                    "departamento": "Magdalena",
                    "ciudades": ["Santa Marta", "Ciénaga", "Fundación", "El Banco"]
                },
                {
                    "departamento": "Cesar",
                    "ciudades": ["Valledupar", "Aguachica", "Codazzi", "Bosconia"]
                },
                {
                    "departamento": "Córdoba",
                    "ciudades": ["Montería", "Cereté", "Sahagún", "Lorica", "Montelíbano", "Planeta Rica"]
                },
                {
                    "departamento": "Sucre",
                    "ciudades": ["Sincelejo", "Corozal", "San Marcos"]
                },
                {
                    "departamento": "Nariño",
                    "ciudades": ["Pasto", "Tumaco", "Ipiales", "Túquerres"]
                },
                {
                    "departamento": "Cauca",
                    "ciudades": ["Popayán", "Santander de Quilichao", "Puerto Tejada"]
                },
                {
                    "departamento": "Boyacá",
                    "ciudades": ["Tunja", "Sogamoso", "Duitama", "Chiquinquirá", "Puerto Boyacá"]
                },
                {
                    "departamento": "Casanare",
                    "ciudades": ["Yopal", "Aguazul", "Paz de Ariporo"]
                },
                {
                    "departamento": "La Guajira",
                    "ciudades": ["Riohacha", "Maicao", "Uribia", "San Juan del Cesar"]
                },
                {
                    "departamento": "Chocó",
                    "ciudades": ["Quibdó", "Istmina", "Condoto"]
                },
                {
                    "departamento": "Caquetá",
                    "ciudades": ["Florencia", "San Vicente del Caguán"]
                },
                {
                    "departamento": "Putumayo",
                    "ciudades": ["Mocoa", "Puerto Asís", "Orito"]
                },
                {
                    "departamento": "San Andrés y Providencia",
                    "ciudades": ["San Andrés", "Providencia"]
                },
                {
                    "departamento": "Amazonas",
                    "ciudades": ["Leticia"]
                },
                {
                    "departamento": "Guainía",
                    "ciudades": ["Inírida"]
                },
                {
                    "departamento": "Guaviare",
                    "ciudades": ["San José del Guaviare"]
                },
                {
                    "departamento": "Vaupés",
                    "ciudades": ["Mitú"]
                },
                {
                    "departamento": "Vichada",
                    "ciudades": ["Puerto Carreño"]
                }
            ];

            // Script para manejar el tipo de lugar dinámicamente
            const tipoLugarSelect = document.getElementById('tipo_lugar');
            const nombreLugarLabel = document.getElementById('nombre_lugar_label');
            const nombreLugarInput = document.getElementById('nombre_lugar');

            function updateNombreLugarField() {
                const value = tipoLugarSelect.value;
                if (value === 'casa') {
                    nombreLugarLabel.innerHTML = 'Nombre de la casa / Condominio <span class="text-xs text-gray-400 font-normal">(opcional)</span>';
                    nombreLugarInput.placeholder = 'Ej. Casa 15, Condominio El Roble';
                    nombreLugarInput.required = false;
                } else if (value === 'apartamento') {
                    nombreLugarLabel.innerHTML = 'Apto / Torre / Bloque <span class="text-red-500">*</span>';
                    nombreLugarInput.placeholder = 'Ej. Apto 402, Torre 3';
                    nombreLugarInput.required = true;
                } else if (value === 'oficina_empresa') {
                    nombreLugarLabel.innerHTML = 'Nombre de la Empresa / Oficina <span class="text-red-500">*</span>';
                    nombreLugarInput.placeholder = 'Ej. NeusPhone S.A.S., Piso 5';
                    nombreLugarInput.required = true;
                } else if (value === 'edificio') {
                    nombreLugarLabel.innerHTML = 'Nombre del Edificio / Conjunto <span class="text-red-500">*</span>';
                    nombreLugarInput.placeholder = 'Ej. Edificio Mirador del Parque';
                    nombreLugarInput.required = true;
                } else {
                    nombreLugarLabel.innerHTML = 'Detalles específicos <span class="text-xs text-gray-400 font-normal">(opcional)</span>';
                    nombreLugarInput.placeholder = 'Ej. Entrada auxiliar, portón negro';
                    nombreLugarInput.required = false;
                }
            }

            tipoLugarSelect.addEventListener('change', updateNombreLugarField);
            updateNombreLugarField();

            function populateDeptoOptions(data) {
                deptoSelect.innerHTML = '<option value="">Seleccione un departamento</option>';
                // Ordenar alfabéticamente
                const sortedData = [...data].sort((a, b) => a.departamento.localeCompare(b.departamento));
                sortedData.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.departamento;
                    option.textContent = item.departamento;
                    
                    // Seleccionar valor anterior en caso de error de validación o del último envío
                    const deptoDefault = "{{ old('departamento', $ultimoEnvio->departamento ?? '') }}";
                    if (deptoDefault === item.departamento) {
                        option.selected = true;
                    }
                    deptoSelect.appendChild(option);
                });

                // Si hay un departamento previamente seleccionado, disparar el evento change para cargar los municipios
                if (deptoSelect.value) {
                    deptoSelect.dispatchEvent(new Event('change'));
                }
            }

            // Intentar cargar datos de GitHub
            fetch('https://raw.githubusercontent.com/marcovega/colombia-json/master/colombia.min.json')
                .then(response => {
                    if (!response.ok) throw new Error('Error al cargar archivo JSON');
                    return response.json();
                })
                .then(data => {
                    window.colombiaData = data;
                    populateDeptoOptions(data);
                })
                .catch(err => {
                    console.warn('Fallo al obtener JSON de GitHub. Usando fallback estático local.', err);
                    window.colombiaData = fallbackData;
                    populateDeptoOptions(fallbackData);
                });

            function calcularEnvio(departamento) {
                const gratis = ['valle del cauca', 'cauca', 'quindio', 'risaralda', 'caldas'];
                const costoMedio = ['antioquia', 'cundinamarca', 'bogotá', 'bogota', 'tolima', 'huila', 'narino', 'putumayo'];
                const depto = departamento.toLowerCase().trim();
                if (gratis.includes(depto)) return 0;
                if (costoMedio.includes(depto)) return 15000;
                return 25000;
            }

            function actualizarTotalEnvio() {
                const depto = deptoSelect.value;
                const subtotal = {{ $subtotal }};
                const descuento = {{ session('cupon_descuento', 0) }};
                const envio = depto ? calcularEnvio(depto) : 0;
                const total = Math.max(0, subtotal - descuento + envio);
                document.getElementById('envio-monto').textContent = envio > 0 ? '$' + envio.toLocaleString('es-CO') : 'Gratis';
                document.getElementById('total-pagar').textContent = '$' + total.toLocaleString('es-CO');
            }

            // Escuchar cambios de Departamento
            deptoSelect.addEventListener('change', function() {
                const selectedDepto = this.value;
                muniSelect.innerHTML = '<option value="">Seleccione un municipio</option>';
                muniSelect.disabled = true;

                if (selectedDepto && window.colombiaData) {
                    const deptoObj = window.colombiaData.find(item => item.departamento === selectedDepto);
                    if (deptoObj && deptoObj.ciudades) {
                        // Ordenar municipios alfabéticamente
                        const sortedCiudades = [...deptoObj.ciudades].sort((a, b) => a.localeCompare(b));
                        
                        sortedCiudades.forEach(ciudad => {
                            const option = document.createElement('option');
                            option.value = ciudad;
                            option.textContent = ciudad;
                            
                            // Seleccionar valor anterior en caso de error de validación o del último envío
                            const muniDefault = "{{ old('municipio', $ultimoEnvio->municipio ?? '') }}";
                            if (muniDefault === ciudad) {
                                option.selected = true;
                            }
                            muniSelect.appendChild(option);
                        });
                        muniSelect.disabled = false;
                    }
                }
                actualizarTotalEnvio();
            });
        });
    </script>
</x-app-layout>
