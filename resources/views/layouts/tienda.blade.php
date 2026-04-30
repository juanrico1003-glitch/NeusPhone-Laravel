<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>NeusPhone</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative bg-blue-50 overflow-x-hidden font-sans">
    @if (!request()->routeIs('dashboard.main'))
        <div class="fixed top-1/2 left-1/2 
                    -translate-x-1/2 -translate-y-1/2 
                    -rotate-[26deg] 
                    text-[60px] md:text-[150px] lg:text-[250px] font-bold 
                    text-blue-600/10 
                    whitespace-nowrap 
                    pointer-events-none 
                    select-none 
                    -z-10">
            NeusPhone
        </div>
    @endif
    <!-- Barra -->
    <nav class="bg-[#004080] shadow-md rounded-lg md:rounded-xl border-white m-2">
        <div class="max-w-7xl mx-auto px-3 md:px-6 py-3 md:py-4">
            <!-- Vista movil -->
            <div class="md:hidden">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <a href="{{ route('dashboard.main') }}" class="text-xl font-bold text-white hover:text-blue-200 transition flex-shrink-0">
                        NeusPhone
                    </a>
                    <!-- Botones derechos -->
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <!-- Carrito -->
                        <a href="{{ route('carrito.index') }}" title="Carrito de compras" class="relative bg-gray-100 hover:bg-gray-200 px-2 py-2 rounded-lg transition">
                            <span class="text-lg">🛒</span>
                            @php
                                $cantidad = count(session('carrito', []));
                            @endphp
                            @if($cantidad > 0)
                                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full font-bold">
                                    {{ $cantidad }}
                                </span>
                            @endif
                        </a>
                        <!-- Menu hamburguesa -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-white hover:text-blue-200 focus:outline-none p-2 transition" title="Menú">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                @auth
                                    <a href="{{ Auth::user()->rol_id == 1 ? route('admin.dashboard') : route('cliente.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100 text-sm font-medium">
                                        Mi Panel
                                    </a>
                                    <hr class="border-gray-200 my-1">
                                @endauth
                                <a href="{{ route('dashboard.main') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100 text-sm">
                                    Inicio
                                </a>
                                <a href="{{ route('tienda') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100 text-sm">
                                    Tienda
                                </a>
                                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-100 text-sm">
                                    Ofertas
                                </a>
                                <a href="{{ route('servicios.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100 text-sm">
                                    Servicio Técnico
                                </a>
                                <a href="{{ route('testimonios.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100 text-sm">
                                    Comentarios
                                </a>
                                <a href="#footer" class="block px-4 py-2 text-gray-800 hover:bg-blue-100 text-sm">
                                    Soporte
                                </a>
                                <a href="#footer" class="block px-4 py-2 text-gray-800 hover:bg-blue-100 text-sm">
                                    Contactanos
                                </a>
                                <hr class="border-gray-200 my-1">
                                @auth
                                    <div class="px-4 py-2 text-gray-600 text-sm font-medium mb-2">
                                        Bienvenido, {{ Auth::user()->nombres }}
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 text-sm font-medium">
                                            Cerrar sesion
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="block px-4 py-2 text-blue-600 hover:bg-blue-50 text-sm font-medium">
                                        Iniciar sesion
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Buscador -->
                <form method="GET" action="{{ route('tienda') }}" class="flex">
                    <input type="text" name="buscar" placeholder="🔍 Buscar producto..." value="{{ request('buscar') }}" class="flex-1 border-0 rounded-l-lg px-3 py-2 text-sm text-gray-800 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-r-lg transition font-medium text-sm">
                        Buscar
                    </button>
                </form>
            </div>

            <!-- Vista PC -->
            <div class="hidden md:flex items-center justify-between gap-6">
                <a href="{{ route('dashboard.main') }}" class="text-2xl md:text-3xl font-bold text-white hover:text-blue-200 transition flex-shrink-0">
                    NeusPhone
                </a>
                <form method="GET" action="{{ route('tienda') }}" class="flex-1 max-w-md">
                    <div class="flex">
                        <input type="text" name="buscar" placeholder="🔍 Buscar producto..." value="{{ request('buscar') }}" class="flex-1 border-0 rounded-l-lg px-4 py-2 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg transition font-medium">
                            Buscar
                        </button>
                    </div>
                </form>
                <div class="flex items-center gap-4 flex-shrink-0">
                    @auth
                        <!-- Bienvenido usuario -->
                        <a href="{{ Auth::user()->rol_id == 1 ? route('admin.dashboard') : route('cliente.dashboard') }}" class="text-white font-semibold hover:text-blue-200 transition text-sm">
                            {{ Auth::user()->nombres }}
                        </a>
                        <!-- Menu hamburguesa -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-white hover:text-blue-200 focus:outline-none p-2 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                    Ofertas
                                </a>
                                <a href="{{ route('dashboard.main') }}#quienes-somos" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                    Quiénes somos
                                </a>
                                <a href="{{ route('servicios.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                    Servicio Técnico
                                </a>
                                <a href="{{ route('testimonios.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                    Dejar Comentario
                                </a>
                                <a href="#footer" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                    Soporte
                                </a>
                                <a href="#footer" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                    Contáctanos
                                </a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-blue-100">
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                            Iniciar sesión
                        </a>
                        <!-- Menu hamburguesa para no autenticados -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-white hover:text-blue-200 focus:outline-none p-2 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <a href="{{ route('servicios.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                    Servicio Técnico
                                </a>
                                <a href="{{ route('dashboard.main') }}#quienes-somos" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                    Quiénes somos
                                </a>
                                <a href="#footer" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                    Soporte
                                </a>
                                <a href="#footer" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                    Contáctanos
                                </a>
                            </div>
                        </div>
                    @endauth
                    <!-- Carrito -->
                    <a href="{{ route('carrito.index') }}" class="relative bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg ml-2 transition" title="Carrito de compras">
                        🛒
                        @php
                            $cantidad = count(session('carrito', []));
                        @endphp
                        @if($cantidad > 0)
                            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full font-bold">
                                {{ $cantidad }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Contenido -->
    <main class="max-w-7xl mx-auto py-6 md:py-10 px-4 md:px-6">
        @yield('contenido')
    </main>
    <!-- Footer -->
    <footer id="footer" class="bg-[#004080] text-white py-8 md:py-10 px-4 md:px-8 mt-10 rounded-lg md:rounded-xl m-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
        <!-- Marca -->
        <div class="flex flex-col items-center text-center">
            <h4 class="font-bold text-base md:text-lg mb-3 md:mb-4">NeusPhone</h4>
            <p class="text-xs md:text-sm opacity-80 leading-relaxed">Venta y reparación de dispositivos electrónicos.</p>
            <!-- Logo -->
            <div class="mt-6 flex justify-center w-full">
                <x-logo class="w-20 h-20 md:w-24 md:h-24 text-white opacity-80 drop-shadow-md" />
            </div>
        </div>
        <!-- Contacto -->
        <div>
            <h4 class="font-bold text-base md:text-lg mb-3 md:mb-4">Contacto</h4>
            <ul class="text-xs md:text-sm opacity-80 space-y-3">
                <li>
                    <a href="mailto:phoneneus@gmail.com" class="flex items-center gap-3 hover:opacity-100 transition-opacity">
                        <x-icons.mail class="w-5 h-5" />
                        <span class="break-all">phoneneus@gmail.com</span>
                    </a>
                </li>
                <li>
                    <a href="https://wa.me/573209643887" target="_blank" class="flex items-center gap-3 hover:opacity-100 transition-opacity">
                        <x-icons.whatsapp class="w-5 h-5" />
                        <span>+57 320 964 3887</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Redes -->
        <div>
            <h4 class="font-bold text-base md:text-lg mb-3 md:mb-4">Redes</h4>
            <ul class="text-xs md:text-sm opacity-80 space-y-3">
                <li>
                    <a href="https://www.facebook.com/share/18S5AyW8Wm/" target="_blank" class="flex items-center gap-3 hover:opacity-100 transition-opacity">
                        <x-icons.facebook class="w-5 h-5" />
                        <span>Facebook</span>
                    </a>
                </li>
                <li>
                    <a href="https://www.instagram.com/neusphone?igsh=MWNkd3l4ZWRiZWpnZw==" target="_blank" class="flex items-center gap-3 hover:opacity-100 transition-opacity">
                        <x-icons.instagram class="w-5 h-5" />
                        <span>@neusphone</span>
                    </a>
                </li>
                <li>
                    <a href="https://tiktok.com/@neusphone2" target="_blank" class="flex items-center gap-3 hover:opacity-100 transition-opacity">
                        <x-icons.tiktok class="w-5 h-5" />
                        <span>@neusphone2</span>
                    </a>
                </li>
                <li>
                    <a href="https://github.com/juanrico1003-glitch" target="_blank" class="flex items-center gap-3 hover:opacity-100 transition-opacity">
                        <x-icons.github class="w-5 h-5" />
                        <span>@juanrico1003-glitch</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Enlaces -->
        <div>
            <h4 class="font-bold text-base md:text-lg mb-3 md:mb-4">Nosotros</h4>
            <ul class="text-xs md:text-sm opacity-80 space-y-2">
                <li>
                    <a href="{{ route('dashboard.main') }}#quienes-somos" class="hover:opacity-100 transition-opacity">Quiénes somos</a>
                </li>
                <li>
                    <a href="{{ route('politicas') }}" class="hover:opacity-100 transition-opacity">Políticas</a>
                </li>
                <li>
                    <a href="{{ route('terminos') }}" class="hover:opacity-100 transition-opacity">Términos</a>
                </li>
            </ul>
        </div>
        <div class="col-span-1 sm:col-span-2 md:col-span-4 mt-6 pt-6 border-t border-white/20 text-center text-xs md:text-sm opacity-80">
            © {{ date('Y') }} NeusPhone. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>