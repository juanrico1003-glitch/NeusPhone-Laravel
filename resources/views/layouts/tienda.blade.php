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

<body class="relative bg-blue-50 overflow-x-hidden">
    @if (!request()->routeIs('dashboard.main'))
    <div class="fixed top-1/2 left-1/2 
                -translate-x-1/2 -translate-y-1/2 
                -rotate-[26deg] 
                text-[250px] font-bold 
                text-blue-600/10 
                whitespace-nowrap 
                pointer-events-none 
                select-none 
                -z-10">
        NeusPhone
    </div>
    @endif
    <!-- Barra nav -->
    <nav class="bg-[#004080] shadow-md rounded-xl border-white m-2">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('dashboard.main') }}" class="text-3xl font-bold text-white hover:text-blue-200">
                NeusPhone
            </a>

            <!-- Buscador centrado -->
            <form method="GET" action="{{ route('tienda') }}" class="flex-1 max-w-md mx-8">
                <input type="text" name="buscar"
                       placeholder="Buscar producto..."
                       value="{{ request('buscar') }}"
                       class="w-full border-0 rounded-lg px-4 py-2 text-gray-800 focus:ring-2 focus:ring-blue-400">
            </form>

            <!-- Sección derecha: Usuario, Menú hamburguesa, Carrito -->
            <div class="flex items-center space-x-2">

                @auth
                    <!-- Bienvenido usuario -->
                    <a href="{{ Auth::user()->rol_id == 1 ? route('admin.dashboard') : route('cliente.dashboard') }}"
                       class="text-white font-semibold mr-2 hover:text-blue-200">
                        Bienvenido {{ Auth::user()->nombres }}
                    </a>

                    <!-- Menú hamburguesa -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-white hover:text-blue-200 focus:outline-none p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Dropdown menú -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                Ofertas
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                Quiénes somos
                            </a>
                            <a href="{{ route('servicios.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                Servicio Técnico
                            </a>
                            <a href="{{ route('testimonios.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                Dejar Comentario
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                Soporte
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
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
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Iniciar sesión
                    </a>

                    <!-- Menú hamburguesa para no autenticados -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-white hover:text-blue-200 focus:outline-none p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Dropdown menú -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <a href="{{ route('servicios.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                Servicio Técnico
                            </a>
                                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                    Quiénes somos
                                </a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                Soporte
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                Contáctanos
                            </a>
                        </div>
                    </div>
                @endauth

                <!-- Carrito -->
                <a href="{{ route('carrito.index') }}"
                   class="relative bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg ml-2">
                    🛒
                    @php
                        $cantidad = count(session('carrito', []));
                    @endphp
                    @if($cantidad > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                            {{ $cantidad }}
                        </span>
                    @endif
                </a>

            </div>

        </div>
    </nav>

    <!-- Contenido -->
    <main class="max-w-7xl mx-auto py-10 px-6">
        @yield('contenido')
    </main>

    <!-- Pie de página -->
    <footer class="bg-[#004080] text-white py-10 px-8 mt-10 rounded-xl m-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <div>
            <h4 class="font-bold text-lg mb-4">NeusPhone</h4>
            <p class="text-sm opacity-80">Venta y reparación de dispositivos electrónicos.</p>
        </div>

        <div>
            <h4 class="font-bold text-lg mb-4">Contacto</h4>
            <p class="text-sm opacity-80 mb-2">Email: contacto@neusphone.com</p>
            <p class="text-sm opacity-80">Tel: 300 000 0000</p>
        </div>

        <div>
            <h4 class="font-bold text-lg mb-4">Redes</h4>
            <ul class="text-sm opacity-80 space-y-2">
                <li class="cursor-pointer hover:opacity-100 transition-opacity">Facebook</li>
                <li class="cursor-pointer hover:opacity-100 transition-opacity">Instagram</li>
                <li class="cursor-pointer hover:opacity-100 transition-opacity">TikTok</li>
            </ul>
        </div>

        <div>
            <h4 class="font-bold text-lg mb-4">Nosotros</h4>
            <ul class="text-sm opacity-80 space-y-2">
                <li class="cursor-pointer hover:opacity-100 transition-opacity">Quiénes somos</li>
                <li class="cursor-pointer hover:opacity-100 transition-opacity">Políticas</li>
                <li class="cursor-pointer hover:opacity-100 transition-opacity">Términos</li>
            </ul>
        </div>
        
        <div class="col-span-1 sm:col-span-2 md:col-span-4 mt-8 pt-8 border-t border-white/20 text-center text-sm opacity-80 inline-block w-full">
            © {{ date('Y') }} NeusPhone. Todos los derechos reservados.
        </div>
    </footer>
</div>
@include('components.gemini-chatbot')
</body>
</html>
