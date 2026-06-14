<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-[#004080] leading-tight">
                Bienvenido, {{ Auth::user()->nombres }}
            </h2>
        </div>
    </x-slot>

    @php $currentUser = Auth::user(); @endphp
    <div x-data="{ tab: 'perfil', showDeleteModal: false }">
        {{-- Success message --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-lg text-sm shadow-sm" 
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        {{-- Tabs --}}
        <div class="flex gap-1 mb-8 border-b border-gray-200 overflow-x-auto">
            <button @click="tab = 'perfil'" :class="tab === 'perfil' ? 'border-b-2 border-[#004080] text-[#004080] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-3 text-sm font-medium transition whitespace-nowrap">
                <svg class="w-4 h-4 inline -mt-0.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Mi Perfil
            </button>
            <button @click="tab = 'pedidos'" :class="tab === 'pedidos' ? 'border-b-2 border-[#004080] text-[#004080] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-3 text-sm font-medium transition whitespace-nowrap">
                <svg class="w-4 h-4 inline -mt-0.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Mis Pedidos
                @if($pedidos->count() > 0)
                <span class="ml-1.5 text-[10px] bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded-full">{{ $pedidos->count() }}</span>
                @endif
            </button>
            <button @click="tab = 'servicios'" :class="tab === 'servicios' ? 'border-b-2 border-[#004080] text-[#004080] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-3 text-sm font-medium transition whitespace-nowrap">
                <svg class="w-4 h-4 inline -mt-0.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Servicios Técnicos
                @if($servicios->count() > 0)
                <span class="ml-1.5 text-[10px] bg-orange-100 text-orange-600 px-1.5 py-0.5 rounded-full">{{ $servicios->count() }}</span>
                @endif
            </button>
            <button @click="tab = 'resenas'" :class="tab === 'resenas' ? 'border-b-2 border-[#004080] text-[#004080] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-3 text-sm font-medium transition whitespace-nowrap">
                <svg class="w-4 h-4 inline -mt-0.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                Mis Reseñas
                @if($testimonios->count() > 0)
                <span class="ml-1.5 text-[10px] bg-yellow-100 text-yellow-600 px-1.5 py-0.5 rounded-full">{{ $testimonios->count() }}</span>
                @endif
            </button>
        </div>

        {{-- TAB: PERFIL --}}
        <div x-show="tab === 'perfil'" x-cloak>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Avatar y datos --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                    @if($currentUser->avatar)
                    <img src="{{ $currentUser->avatar }}" alt="Avatar" class="w-24 h-24 rounded-full mx-auto object-cover ring-4 ring-blue-100 shadow-md">
                    @else
                    <div class="w-24 h-24 rounded-full mx-auto bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center ring-4 ring-blue-100 shadow-md">
                        <span class="text-3xl font-bold text-white">{{ substr($currentUser->nombres, 0, 1) }}{{ substr($currentUser->apellidos ?? '', 0, 1) }}</span>
                    </div>
                    @endif
                    <h3 class="mt-4 font-bold text-gray-800 text-lg">{{ $currentUser->nombres }} {{ $currentUser->apellidos }}</h3>
                    <p class="text-sm text-gray-500">{{ $currentUser->correo }}</p>
                    @if($currentUser->telefono)
                    <p class="text-sm text-gray-400 mt-1">{{ $currentUser->telefono }}</p>
                    @endif
                    <div class="mt-4 text-xs text-gray-400">
                        Miembro desde {{ $currentUser->created_at?->format('M Y') ?? 'siempre' }}
                    </div>
                </div>

                {{-- Formularios --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Datos personales --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-1">Información personal</h3>
                        <p class="text-sm text-gray-500 mb-5">Actualiza tus datos de perfil</p>
                        <form method="POST" action="{{ route('cliente.profile.update') }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombres</label>
                                    <input type="text" name="nombres" value="{{ old('nombres', $currentUser->nombres) }}" required
                                           class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm @error('nombres') border-red-400 @enderror">
                                    @error('nombres') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                                    <input type="text" name="apellidos" value="{{ old('apellidos', $currentUser->apellidos) }}" required
                                           class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm @error('apellidos') border-red-400 @enderror">
                                    @error('apellidos') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                                    <input type="email" name="correo" value="{{ old('correo', $currentUser->correo) }}" required
                                           class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm @error('correo') border-red-400 @enderror">
                                    @error('correo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">N° de cédula</label>
                                    <input type="text" name="cedula" value="{{ old('cedula', $currentUser->cedula) }}" placeholder="1234567890"
                                           class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm @error('cedula') border-red-400 @enderror">
                                    @error('cedula') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                    <input type="text" name="telefono" value="{{ old('telefono', $currentUser->telefono) }}" placeholder="+57 300 000 0000"
                                           class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm @error('telefono') border-red-400 @enderror">
                                    @error('telefono') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <button type="submit" class="bg-[#004080] hover:bg-blue-800 text-white px-6 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                                    Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Contraseña --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-1">
                            {{ $currentUser->password ? 'Cambiar contraseña' : 'Establecer contraseña' }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-5">
                            @if($currentUser->password)
                                Actualiza tu contraseña de acceso
                            @else
                                Tu cuenta se creó con Google. Establece una contraseña para iniciar sesión con correo y contraseña también.
                            @endif
                        </p>
                        <form method="POST" action="{{ route('cliente.password.update') }}" class="space-y-4 max-w-md">
                            @csrf
                            @if($currentUser->password)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña actual</label>
                                <input type="password" name="current_password" required
                                       class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm @error('current_password') border-red-400 @enderror">
                                @error('current_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña</label>
                                <input type="password" name="password" required minlength="8"
                                       class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm @error('password') border-red-400 @enderror">
                                @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                            <div class="flex justify-end pt-2">
                                <button type="submit" class="bg-[#004080] hover:bg-blue-800 text-white px-6 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                                    {{ $currentUser->password ? 'Actualizar contraseña' : 'Establecer contraseña' }}
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Eliminar cuenta --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6">
                        <h3 class="font-bold text-red-700 mb-1">Eliminar cuenta</h3>
                        <p class="text-sm text-gray-500 mb-2">Una vez solicitada la eliminación, tendrás <strong>30 días</strong> para recuperar tu cuenta iniciando sesión. Después de ese plazo, todos tus datos serán eliminados permanentemente.</p>
                        <button @click="showDeleteModal = true" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                            Solicitar eliminación
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal eliminar cuenta --}}
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4 p-6" @click.away="showDeleteModal = false">
                <h3 class="text-lg font-bold text-gray-800 mb-2">¿Eliminar tu cuenta?</h3>
                <p class="text-sm text-gray-600 mb-4">Ingresa tu contraseña para confirmar que deseas programar la eliminación de tu cuenta.</p>
                <form method="POST" action="{{ route('cliente.delete.request') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña actual</label>
                        <input type="password" name="delete_password" required
                               class="w-full rounded-lg border-gray-300 bg-gray-50 focus:border-red-500 focus:ring-red-500 text-sm">
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showDeleteModal = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition">Cancelar</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition shadow-sm">Confirmar eliminación</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TAB: PEDIDOS --}}
        <div x-show="tab === 'pedidos'" x-cloak>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">Mis Pedidos</h3>
                    <a href="{{ route('tienda') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Ir a la tienda →</a>
                </div>
                <div class="p-5">
                    @forelse($pedidos as $pedido)
                    <div class="flex items-center justify-between py-4 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="font-semibold text-gray-800">Pedido #{{ $pedido->id }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $pedido->created_at?->format('d/m/Y h:i A') ?? '—' }}</p>
                            <p class="text-sm text-gray-600 mt-1">
                                Total: <span class="font-bold text-green-600">${{ number_format($pedido->total, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide
                                @if($pedido->estado === 'entregado') bg-green-50 text-green-600
                                @elseif($pedido->estado === 'enviado') bg-blue-50 text-blue-600
                                @elseif($pedido->estado === 'pagado') bg-indigo-50 text-indigo-600
                                @elseif($pedido->estado === 'pendiente') bg-yellow-50 text-yellow-600
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ $pedido->estado }}
                            </span>
                            <div class="mt-2">
                                <a href="{{ route('pedidos.show', $pedido->id) }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Ver detalle →</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <p class="text-gray-500 font-medium">No has realizado compras todavía</p>
                        <a href="{{ route('tienda') }}" class="inline-block mt-3 text-sm text-blue-600 hover:text-blue-800 font-medium">Explorar productos →</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- TAB: SERVICIOS --}}
        <div x-show="tab === 'servicios'" x-cloak>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">Servicios Técnicos</h3>
                    <a href="{{ route('servicios.create') }}" class="bg-[#004080] hover:bg-blue-800 text-white text-sm px-4 py-2 rounded-lg transition font-medium">+ Nueva solicitud</a>
                </div>
                <div class="p-5 space-y-4">
                    @forelse($servicios as $s)
                    <div class="border border-gray-100 rounded-xl p-4 hover:shadow-sm transition">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-mono font-bold text-gray-400">#{{ $s->id }}</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $s->servicio?->nombre ?? 'Servicio' }}</span>
                            </div>
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide
                                @if($s->estado === 'pendiente') bg-yellow-50 text-yellow-600
                                @elseif($s->estado === 'en_revision') bg-blue-50 text-blue-600
                                @elseif($s->estado === 'reparado') bg-green-50 text-green-600
                                @elseif($s->estado === 'entregado') bg-indigo-50 text-indigo-600
                                @else bg-red-50 text-red-600 @endif">
                                {{ str_replace('_', ' ', $s->estado ?? 'pendiente') }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-sm">
                            <div>
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide block">Equipo</span>
                                @if($s->tipo_equipo)
                                <span class="text-gray-700">{{ ucfirst($s->tipo_equipo) }}
                                    @if($s->marca_equipo) · {{ $s->marca_equipo }} @endif
                                    @if($s->modelo_equipo) · {{ $s->modelo_equipo }} @endif
                                </span>
                                @else
                                <span class="text-gray-400">Sin especificar</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide block">Contacto</span>
                                <span class="text-gray-700">{{ $s->telefono ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide block">Creado</span>
                                <span class="text-gray-700">{{ $s->created_at?->format('d/m/Y') ?? '—' }}</span>
                            </div>
                        </div>
                        @if($s->descripcion_problema)
                        <p class="mt-2 text-xs text-gray-500">{{ Str::limit($s->descripcion_problema, 120) }}</p>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="text-gray-500 font-medium">No tienes solicitudes de servicio</p>
                        <a href="{{ route('servicios.create') }}" class="inline-block mt-3 text-sm text-blue-600 hover:text-blue-800 font-medium">Crear una →</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- TAB: RESEÑAS --}}
        <div x-show="tab === 'resenas'" x-cloak>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">Mis Reseñas</h3>
                    <a href="{{ route('testimonios.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-4 py-2 rounded-lg transition font-medium">+ Nueva reseña</a>
                </div>
                <div class="p-5 space-y-4">
                    @forelse($testimonios as $t)
                    <div class="border border-gray-100 rounded-xl p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-gray-800 text-sm">
                                        {{ $t->producto?->nombre ?? 'Producto' }}
                                    </span>
                                    <span class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= ($t->calificacion ?? 0) ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </span>
                                </div>
                                @if($t->comentario)
                                <p class="text-sm text-gray-600 mt-1">{{ $t->comentario }}</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-2">{{ $t->created_at?->format('d/m/Y') ?? '' }}</p>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase
                                {{ ($t->estado ?? 1) ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                {{ ($t->estado ?? 1) ? 'Publicado' : 'Pendiente' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <p class="text-gray-500 font-medium">No has escrito reseñas todavía</p>
                        <a href="{{ route('tienda') }}" class="inline-block mt-3 text-sm text-blue-600 hover:text-blue-800 font-medium">Califica tus compras →</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>
