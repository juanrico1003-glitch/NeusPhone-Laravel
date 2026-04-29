@extends('layouts.tienda')

@section('contenido')
<!-- Fondo -->
<div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 rotate-0 text-[60px] font-bold text-blue-600/10 whitespace-nowrap pointer-events-none select-none -z-10 text-transition" id="bgTextAnim">
    NeusPhone
</div>

<style>
    .text-transition { will-change: transform, font-size; }

    /* Tarjetas interactivas usando GSAP */
    .card-anim {
        visibility: hidden;
    }

    /* El Marquee continuo */
    .marquee-container {
        display: flex;
        width: 200%;
    }

    /* Efecto Cristal */
    .glass {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
</style>

<!-- Hero expandido -->
<section class="relative min-h-screen md:h-[calc(100vh-100px)] flex flex-col items-center justify-center overflow-hidden px-4 md:px-0">
    <!-- Iconos flotantes moviles pequeños -->
    <div class="gsap-float absolute top-10 md:top-20 left-5 md:left-10 lg:left-32 opacity-20 text-blue-600 hidden sm:block">
        <svg class="w-16 md:w-24 h-16 md:h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M16 1H8C6.34 1 5 2.34 5 4v16c0 1.66 1.34 3 3 3h8c1.66 0 3-1.34 3-3V4c0-1.66-1.34-3-3-3zm-4 20c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm3.25-3H8.75C8.34 18 8 17.66 8 17.25V4.75C8 4.34 8.34 4 8.75 4h6.5c.41 0 .75.34 .75.75v12.5c0 .41-.34.75-.75.75z"/></svg>
    </div>
    <div class="gsap-float-rev absolute bottom-20 md:bottom-40 right-5 md:right-10 lg:right-32 opacity-20 text-indigo-600 hidden sm:block">
        <svg class="w-20 md:w-28 h-20 md:h-28" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
    </div>

    <!-- Contenido y Slogan -->
    <div class="z-10 text-center mt-12 md:mt-32 max-w-4xl">
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#004080] font-extrabold mb-4 md:mb-6 tracking-tight drop-shadow-md leading-tight">
            Tecnología de Punta y Servicio Técnico Especializado
        </h1>
        <p class="text-base md:text-lg lg:text-xl text-black-800/80 font-medium mb-6 md:mb-8">
            Descubre los mejores precios en dispositivos o repara el tuyo con expertos certificados.
        </p>
        <button onclick="document.getElementById('ofertasEstrella').scrollIntoView({behavior: 'smooth'})" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 md:px-8 py-3 md:py-4 rounded-full font-bold text-base md:text-lg hover:from-blue-700 hover:to-indigo-700 hover:shadow-xl hover:shadow-blue-500/40 transition-all transform hover:-translate-y-1 active:scale-95">
            Ver Ofertas de la Semana
        </button>
    </div>

    <!-- Indicador Scroll -->
    <div class="text-center animate-bounce text-blue-600 opacity-60 mt-auto mb-6 md:mb-10">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 md:h-8 w-6 md:w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>
</section>

<!-- Marcas -->
<div class="w-full bg-blue-900/5 py-6 md:py-8 overflow-hidden my-8 md:my-10 border-y border-blue-100">
    <div class="marquee-container flex items-center justify-around gap-4 md:gap-8 gsap-marquee">
        <!-- Primer Grupo -->
        <div class="w-1/2 flex items-center justify-around gap-3 md:gap-6 px-2 md:px-4 whitespace-nowrap">
            <span class="text-lg md:text-2xl lg:text-4xl font-extrabold text-blue-900/40 tracking-wider flex-shrink-0">APPLE</span>
            <span class="text-lg md:text-2xl lg:text-4xl font-extrabold text-blue-900/40 tracking-wider flex-shrink-0">SAMSUNG</span>
            <span class="text-lg md:text-2xl lg:text-4xl font-extrabold text-blue-900/40 tracking-wider flex-shrink-0">XIAOMI</span>
            <span class="text-lg md:text-2xl lg:text-4xl font-extrabold text-blue-900/40 tracking-wider flex-shrink-0">MOTOROLA</span>
            <span class="text-lg md:text-2xl lg:text-4xl font-extrabold text-blue-900/40 tracking-wider flex-shrink-0">HUAWEI</span>
        </div>
        <!-- Segundo Grupo clonado para el efecto loop  -->
        <div class="w-1/2 flex items-center justify-around gap-3 md:gap-6 px-2 md:px-4 whitespace-nowrap">
            <span class="text-lg md:text-2xl lg:text-4xl font-extrabold text-blue-900/40 tracking-wider flex-shrink-0">APPLE</span>
            <span class="text-lg md:text-2xl lg:text-4xl font-extrabold text-blue-900/40 tracking-wider flex-shrink-0">SAMSUNG</span>
            <span class="text-lg md:text-2xl lg:text-4xl font-extrabold text-blue-900/40 tracking-wider flex-shrink-0">XIAOMI</span>
            <span class="text-lg md:text-2xl lg:text-4xl font-extrabold text-blue-900/40 tracking-wider flex-shrink-0">MOTOROLA</span>
            <span class="text-lg md:text-2xl lg:text-4xl font-extrabold text-blue-900/40 tracking-wider flex-shrink-0">HUAWEI</span>
        </div>
    </div>
</div>

<!-- Ofertas -->
<div id="ofertasEstrella" class="max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-20">
    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-center text-[#004080] mb-8 md:mb-12">✨ Ofertas de la Semana ✨</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8">
        @forelse($productosEstrella as $producto)
            <div class="card-anim glass rounded-2xl p-4 md:p-6 flex flex-col hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(37,99,235,0.15)] transition-all duration-300 relative group overflow-hidden h-full">
                <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-blue-50/20 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                <div class="relative aspect-square bg-white rounded-xl overflow-hidden mb-4 shadow-sm">
                    <img src="{{ asset('productos/'.(!empty($producto->imagenes) ? $producto->imagenes[0] : 'default.png')) }}" alt="{{ $producto->nombre }}" class="w-full h-full object-contain p-2">
                </div>
                <div class="mt-auto">
                    <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded inline-block mb-2 uppercase tracking-wide">
                        {{ $producto->tipo === 'nuevo' ? 'Nuevo' : 'Semi Nuevo' }}
                    </span>
                    <h3 class="font-bold text-base md:text-lg text-gray-800 line-clamp-2 leading-tight mb-2">{{ $producto->nombre }}</h3>
                    <p class="text-xl md:text-2xl font-extrabold text-green-600 mb-4">${{ number_format($producto->precio, 0, ',', '.') }}</p>
                    <a href="{{ route('tienda.producto', $producto->id) }}" class="block w-full py-2 md:py-2.5 bg-[#004080] text-white text-center rounded-lg hover:bg-blue-800 transition font-medium shadow-md text-sm md:text-base">
                        Ver Detalles
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500 py-10 font-medium">Aún no hay ofertas registradas en este momento.</div>
        @endforelse
    </div>
</div>

<!-- Categorias -->
<div id="contentCards" class="pb-10 overflow-hidden">
    <!-- Carta 1 -->
    <section class="min-h-screen md:min-h-[90vh] flex justify-center items-center py-10 px-4">
        <a href="{{ route('tienda') }}?tipo=nuevo" class="card-anim w-full max-w-5xl min-h-[50vh] md:h-[65vh] rounded-3xl md:rounded-[40px] shadow-[0_20px_60px_rgba(0,0,0,0.06)] bg-white/90 backdrop-blur-md flex flex-col justify-center px-6 md:px-20 hover:scale-[1.02] hover:shadow-[0_40px_80px_rgba(37,99,235,0.15)] transition-all duration-[600ms] block relative overflow-hidden group border border-white/50">
            <div class="absolute -right-32 -top-32 w-[400px] md:w-[500px] h-[400px] md:h-[500px] bg-blue-100 rounded-full blur-[80px] opacity-60 group-hover:bg-blue-200 transition-colors duration-500"></div>
            <h2 class="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-black text-blue-600 mb-3 md:mb-6 leading-tight z-10 relative drop-shadow-sm tracking-tight">Dispositivos<br>Nuevos</h2>
            <p class="text-lg md:text-2xl lg:text-3xl text-blue-900 font-medium z-10 relative opacity-90">Última tecnología al alcance de tu mano</p>
        </a>
    </section>

    <!-- Carta 2 -->
    <section class="min-h-screen md:min-h-[90vh] flex justify-center items-center py-10 px-4">
        <a href="{{ route('tienda') }}?tipo=usado" class="card-anim w-full max-w-5xl min-h-[50vh] md:h-[65vh] rounded-3xl md:rounded-[40px] shadow-[0_20px_60px_rgba(0,0,0,0.06)] bg-white/90 backdrop-blur-md flex flex-col justify-center px-6 md:px-20 hover:scale-[1.02] hover:shadow-[0_40px_80px_rgba(34,197,94,0.15)] transition-all duration-[600ms] block relative overflow-hidden group border border-white/50">
            <div class="absolute -left-32 -bottom-32 w-[400px] md:w-[500px] h-[400px] md:h-[500px] bg-green-100 rounded-full blur-[80px] opacity-60 group-hover:bg-green-200 transition-colors duration-500"></div>
            <h2 class="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-black text-green-600 mb-3 md:mb-6 leading-tight z-10 relative drop-shadow-sm tracking-tight">Dispositivos<br>Usados</h2>
            <p class="text-lg md:text-2xl lg:text-3xl text-green-900 font-medium z-10 relative opacity-90">Equipos 100% probados y certificados</p>
        </a>
    </section>

    <!-- Carta 3 -->
    <section class="min-h-screen md:min-h-[90vh] flex justify-center items-center py-10 px-4">
        <a href="{{ route('servicios.create') }}" class="card-anim w-full max-w-5xl min-h-[50vh] md:h-[65vh] rounded-3xl md:rounded-[40px] shadow-[0_20px_60px_rgba(0,0,0,0.06)] bg-white/90 backdrop-blur-md flex flex-col justify-center px-6 md:px-20 hover:scale-[1.02] hover:shadow-[0_40px_80px_rgba(249,115,22,0.15)] transition-all duration-[600ms] block relative overflow-hidden group border border-white/50">
            <div class="absolute left-1/2 -top-40 w-[500px] md:w-[600px] h-[500px] md:h-[600px] bg-orange-100 rounded-full blur-[100px] opacity-60 group-hover:bg-orange-200 transition-colors duration-500 -translate-x-1/2"></div>
            <h2 class="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-black text-orange-500 mb-3 md:mb-6 leading-tight z-10 relative drop-shadow-sm tracking-tight text-center">Servicio<br>Técnico</h2>
            <p class="text-lg md:text-2xl lg:text-3xl text-orange-900 font-medium z-10 relative opacity-90 text-center">Tus reparaciones en las mejores manos</p>
        </a>
    </section>
</div>
</div>

<!-- Elegirnos -->
<div class="bg-white/40 py-16 md:py-24 border-y border-white/40 mt-10">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-center text-[#004080] mb-12 md:mb-16">¿Por qué elegir nuestra tienda?</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            
            <div class="glass p-6 md:p-8 rounded-2xl text-center hover:-translate-y-2 transition-transform duration-300 shadow-sm hover:shadow-lg">
                <div class="w-14 md:w-16 h-14 md:h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-6 shadow-inner">
                    <svg class="w-6 md:w-8 h-6 md:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h3 class="text-base md:text-lg font-bold text-gray-800 mb-2">Pagos Seguros</h3>
                <p class="text-gray-600 text-sm">Transacciones encriptadas y máxima protección para tu dinero.</p>
            </div>

            <div class="glass p-6 md:p-8 rounded-2xl text-center hover:-translate-y-2 transition-transform duration-300 shadow-sm hover:shadow-lg">
                <div class="w-14 md:w-16 h-14 md:h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-6 shadow-inner">
                    <svg class="w-6 md:w-8 h-6 md:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-base md:text-lg font-bold text-gray-800 mb-2">Máxima Garantía</h3>
                <p class="text-gray-600 text-sm">Todos nuestros equipos son auditados con estándares rigurosos.</p>
            </div>

            <div class="glass p-6 md:p-8 rounded-2xl text-center hover:-translate-y-2 transition-transform duration-300 shadow-sm hover:shadow-lg">
                <div class="w-14 md:w-16 h-14 md:h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-6 shadow-inner">
                    <svg class="w-6 md:w-8 h-6 md:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                </div>
                <h3 class="text-base md:text-lg font-bold text-gray-800 mb-2">Envíos Rápidos</h3>
                <p class="text-gray-600 text-sm">Entregas ágiles a domicilio con las mejores empresas de mensajería.</p>
            </div>

            <div class="glass p-6 md:p-8 rounded-2xl text-center hover:-translate-y-2 transition-transform duration-300 shadow-sm hover:shadow-lg">
                <div class="w-14 md:w-16 h-14 md:h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 md:mb-6 shadow-inner">
                    <svg class="w-6 md:w-8 h-6 md:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-base md:text-lg font-bold text-gray-800 mb-2">Soporte 24/7</h3>
                <p class="text-gray-600 text-sm">Nuestro equipo y asistente virtual siempre listos para ayudarte.</p>
            </div>

        </div>
    </div>
</div>

<!-- Quiénes somos -->
<div id="quienes-somos" class="max-w-7xl mx-auto px-4 md:px-6 py-16 md:py-24 mt-10">
    <div class="glass p-8 md:p-12 rounded-3xl shadow-[0_20px_40px_rgba(0,64,128,0.1)] border border-white flex flex-col md:flex-row items-center gap-8 md:gap-12 relative overflow-hidden">
        <!-- Decoracion de fondo -->
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-100 rounded-full blur-[80px] opacity-60 pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-indigo-100 rounded-full blur-[80px] opacity-60 pointer-events-none"></div>

        <div class="w-full md:w-1/2 relative z-10">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-[#004080] mb-6 drop-shadow-sm">Quiénes Somos</h2>
            <div class="space-y-4">
                <p class="text-gray-700 text-base md:text-lg leading-relaxed font-medium">
                    En <span class="text-blue-700 font-bold">NeusPhone</span> somos unos apasionados por la tecnología y la innovación. Nacimos con la misión de acercar los mejores dispositivos electronicos y soluciones técnicas a nuestros clientes, garantizando siempre la máxima calidad y confianza.
                </p>
                <p class="text-gray-700 text-base md:text-lg leading-relaxed font-medium">
                    Contamos con un equipo de expertos dedicados a brindarte un servicio técnico especializado y asesoramiento personalizado para que encuentres el equipo perfecto para ti, ya sea nuevo o usado, certificado por nuestros técnicos.
                </p>
            </div>
        </div>
        <div class="w-full md:w-1/2 flex justify-center items-center relative z-10 py-6 md:py-0">
            <img src="{{ asset('favicon.svg') }}" alt="Logo NeusPhone" class="w-40 sm:w-48 md:w-64 lg:w-80 h-auto drop-shadow-2xl transform hover:scale-105 hover:rotate-3 transition-all duration-500">
        </div>
    </div>
</div>

<!-- Testimonios -->
<div class="max-w-7xl mx-auto px-4 md:px-6 py-16 md:py-24 mb-10">
    <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-center text-[#004080] mb-12 md:mb-16">Lo que dicen nuestros clientes</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @forelse($testimonios as $testimonio)
        <div class="bg-white p-6 md:p-8 rounded-2xl md:rounded-3xl shadow-lg md:shadow-xl shadow-blue-900/5 relative overflow-hidden transform hover:-translate-y-1 transition duration-300">
            <div class="flex items-center space-x-1 text-yellow-400 mb-4">
                @for($i=0; $i<$testimonio->calificacion; $i++)
                <svg class="w-4 md:w-5 h-4 md:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <p class="text-gray-700 font-medium mb-6 leading-relaxed text-sm md:text-base">
               "{{ $testimonio->comentario }}"
            </p>
            <div class="flex items-center space-x-4">
                @php
                    $nombre = $testimonio->usuario->nombres ?? 'Cliente';
                    $inicial = strtoupper(substr($nombre, 0, 1));
                @endphp
                <div class="w-10 md:w-12 h-10 md:h-12 bg-blue-200 rounded-full flex items-center justify-center text-blue-700 font-bold text-lg flex-shrink-0">{{ $inicial }}</div>
                <div>
                    <h4 class="font-bold text-gray-800 text-sm md:text-base">{{ $nombre }}</h4>
                    <span class="text-xs text-gray-500 uppercase tracking-widest">Cliente Nuevo</span>
                </div>
            </div>
            <div class="absolute top-0 right-0 -mr-6 -mt-6 text-6xl md:text-9xl text-blue-50 opacity-50 font-serif">"</div>
        </div>
        @empty
        <div class="col-span-full text-center text-gray-500 py-10 font-medium">Aún no hay testimonios de nuestros clientes. ¡Sé el primero en comprar y dejar uno!</div>
        @endforelse
    </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const text = document.getElementById("bgTextAnim");
    const content = document.getElementById("contentCards");

    if(!text || !content) return;

    function getScrollLimits(){
        const start = content.offsetTop - window.innerHeight / 2.5; 
        const end = start + content.offsetHeight;
        return {start, end};
    }

    let ticking = false;

    window.addEventListener("scroll", () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const scroll = window.scrollY;
                let {start, end} = getScrollLimits();
                
                start = start < 0 ? 0 : start;

                if(scroll <= start){
                    text.style.fontSize = "60px";
                    text.style.transform = "translate(-50%, -50%) rotate(0deg)";
                } else {
                    let progress = (scroll - start) / (end - start);
                    if(progress > 1) progress = 1;

                    let size = 60 + (190 * progress);
                    let rotation = -26 * progress;

                    text.style.fontSize = size + "px";
                    text.style.transform = `translate(-50%, -50%) rotate(${rotation}deg)`;
                }
                ticking = false;
            });
            ticking = true;
        }
    });

    /* Animaciones con GSAP */
    window.addEventListener('load', () => {
        if (typeof window.gsap !== 'undefined') {
            const gsap = window.gsap;

            // Animacion del telefono
            gsap.to(".gsap-float", {
                y: -20,
                rotation: 5,
                duration: 3,
                ease: "power1.inOut",
                yoyo: true,
                repeat: -1
            });

            // Animacion del mundo
            gsap.to(".gsap-float-rev", {
                y: 20,
                rotation: -5,
                duration: 3.5,
                ease: "power1.inOut",
                yoyo: true,
                repeat: -1
            });

            // Animacion de marcas
            const marquee = document.querySelector(".gsap-marquee");
            if (marquee) {
                const marqueeAnim = gsap.to(marquee, {
                    xPercent: -50,
                    ease: "none",
                    duration: 20,
                    repeat: -1
                });

                marquee.parentElement.addEventListener("mouseenter", () => marqueeAnim.pause());
                marquee.parentElement.addEventListener("mouseleave", () => marqueeAnim.play());
            }

            // Animacion de las tarjetas
            gsap.utils.toArray('.card-anim').forEach(card => {
                gsap.fromTo(card, 
                    { autoAlpha: 0, y: 100, scale: 0.95 },
                    {
                        autoAlpha: 1, 
                        y: 0, 
                        scale: 1,
                        duration: 0.8,
                        ease: "power3.out",
                        scrollTrigger: {
                            trigger: card,
                            start: "top 85%",
                            toggleActions: "play none none none"
                        }
                    }
                );
            });
        } else {
            console.warn("GSAP no esta disponible en window.");
        }
    });
});
</script>
@endsection
