<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NeusPhone') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased relative bg-blue-50 overflow-x-hidden">
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
    <div class="min-h-screen flex flex-col">

        {{-- Navbar --}}
        <nav class="bg-[#004080] shadow-md rounded-lg md:rounded-xl border-white m-2">
            <div class="max-w-7xl mx-auto px-4 md:px-6 py-3 md:py-4 flex justify-between items-center">

                {{-- Logo --}}
                <a href="{{ route('dashboard.main') }}"
                   class="text-xl md:text-2xl font-bold text-white hover:text-blue-200 transition whitespace-nowrap">
                    NeusPhone
                </a>

                {{-- Usuario --}}
                <div class="flex items-center gap-2 md:gap-4">

                    <span class="text-white text-xs md:text-sm font-medium truncate max-w-[150px]">
                        {{ auth()->user()->nombres ?? '' }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 md:px-4 py-2 md:py-2 rounded-lg text-xs md:text-sm transition font-medium whitespace-nowrap">
                            Cerrar sesión
                        </button>
                    </form>

                </div>

            </div>
        </nav>

        {{-- Header --}}
        @isset($header)
            <header class="bg-blue-100 border-b border-blue-200">
                <div class="max-w-7xl mx-auto py-4 md:py-6 px-4 md:px-6">
                    {{ $header }}
                </div>
            </header>
        @endisset


        {{-- Contenido --}}
        <main class="flex-1 max-w-7xl mx-auto w-full px-4 md:px-6 py-6 md:py-8">
            {{ $slot }}
        </main>


        {{-- Footer --}}
        <footer id="footer" class="bg-[#004080] text-white py-8 md:py-10 px-4 md:px-8 mt-10 rounded-lg md:rounded-xl m-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            <div>
                <h4 class="font-bold text-lg mb-3 md:mb-4">NeusPhone</h4>
                <p class="text-xs md:text-sm opacity-80 leading-relaxed">Venta y reparación de dispositivos electrónicos.</p>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-3 md:mb-4">Contacto</h4>
                <p class="text-xs md:text-sm opacity-80 mb-1 break-all">Email: phoneneus@gmail.com</p>
                <p class="text-xs md:text-sm opacity-80">Tel: 3209643887</p>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-3 md:mb-4">Redes</h4>
                <ul class="text-xs md:text-sm opacity-80 space-y-2">
                    <li><a href="https://www.facebook.com/share/18S5AyW8Wm/" target="_blank" class="hover:opacity-100 transition-opacity">Facebook</a></li>
                    <li><a href="https://www.instagram.com/neusphone?igsh=MWNkd3l4ZWRiZWpnZw==" target="_blank" class="hover:opacity-100 transition-opacity">Instagram</a></li>
                    <li><a href="#" class="hover:opacity-100 transition-opacity">TikTok</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-3 md:mb-4">Nosotros</h4>
                <ul class="text-xs md:text-sm opacity-80 space-y-2">
                    <li><a href="{{ route('dashboard.main') }}#quienes-somos" class="hover:opacity-100 transition-opacity">Quiénes somos</a></li>
                    <li><a href="{{ route('politicas') }}" class="hover:opacity-100 transition-opacity">Políticas</a></li>
                    <li><a href="{{ route('terminos') }}" class="hover:opacity-100 transition-opacity">Términos</a></li>
                </ul>
            </div>
            
            <div class="col-span-1 sm:col-span-2 md:col-span-4 mt-6 pt-6 border-t border-white/20 text-center text-xs md:text-sm opacity-80">
                © {{ date('Y') }} NeusPhone. Panel administrativo.
            </div>
        </footer>

    </div>
</body>
</html>
