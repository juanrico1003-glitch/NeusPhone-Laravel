<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Configuración básica --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Token CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Título --}}
    <title>{{ config('app.name', 'NeusPhone') }}</title>

    {{-- Fuente --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    {{-- CSS y JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased relative bg-blue-50 overflow-x-hidden">
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
    <div class="min-h-screen flex flex-col">

        {{-- NAVBAR --}}
        <nav class="bg-[#004080] shadow-md rounded-xl border-white m-2">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

                {{-- Logo --}}
                <a href="{{ route('dashboard.main') }}"
                   class="text-2xl font-bold text-white hover:text-blue-700 transition">
                    NeusPhone
                </a>

                {{-- Usuario --}}
                <div class="flex items-center gap-4">

                    <span class="text-white text-sm">
                        {{ auth()->user()->nombres ?? '' }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                            Cerrar sesión
                        </button>
                    </form>

                </div>

            </div>
        </nav>


        {{-- HEADER --}}
        @isset($header)
            <header class="bg-blue-100 border-b border-blue-200">
                <div class="max-w-7xl mx-auto py-6 px-6">
                    {{ $header }}
                </div>
            </header>
        @endisset


        {{-- CONTENIDO --}}
        <main class="flex-1 max-w-7xl mx-auto w-full px-6 py-8">
            {{ $slot }}
        </main>


        {{-- FOOTER --}}
        <footer class="bg-[#004080] text-white py-10 px-8 mt-10 rounded-xl m-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <div>
                <h4 class="font-bold text-lg mb-4">NeusPhone</h4>
                <p class="text-sm opacity-80">Venta y reparación de dispositivos electrónicos.</p>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4">Contacto</h4>
                <p class="text-sm opacity-80 mb-2">Email: juanrico1003@gmail.com.com</p>
                <p class="text-sm opacity-80">Tel: 3209643887</p>
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
                © {{ date('Y') }} NeusPhone. Panel administrativo.
            </div>
        </footer>

    </div>
@include('components.gemini-chatbot')
</body>
</html>
