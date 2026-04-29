@extends('layouts.tienda')

@section('contenido')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-3xl p-8 md:p-12 border border-blue-100">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-5xl font-extrabold text-[#004080] mb-4">Políticas de la Tienda</h1>
            <p class="text-lg text-blue-600 font-medium">Transparencia y seguridad en cada compra.</p>
        </div>

        <div class="space-y-8 text-gray-700 leading-relaxed">
            
            <section class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">1. Garantías de Equipos</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 marker:text-blue-500">
                    <li><strong>Equipos Nuevos:</strong> Cuentan con 1 año de garantía directa con el fabricante por defectos de fábrica.</li>
                    <li><strong>Equipos Seminuevos/Usados:</strong> Ofrecemos una garantía de 3 a 6 meses (según el equipo) cubriendo exclusivamente fallos internos o de hardware no provocados por caídas o humedad.</li>
                    <li>La garantía queda anulada si el equipo presenta golpes, humedad, o si ha sido manipulado por técnicos externos a NeusPhone.</li>
                </ul>
            </section>

            <section class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">2. Envíos y Entregas</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 marker:text-blue-500">
                    <li>Realizamos envíos a nivel nacional. Los tiempos de entrega estimados son de 1 a 3 días hábiles dependiendo de la ubicación.</li>
                    <li>Todos nuestros envíos van asegurados por el valor total del producto.</li>
                    <li>Una vez despachado el pedido, te enviaremos la guía de rastreo al correo registrado.</li>
                </ul>
            </section>

            <section class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">3. Privacidad y Tratamiento de Datos</h2>
                </div>
                <ul class="list-disc pl-6 space-y-2 marker:text-blue-500">
                    <li>Tus datos personales y de contacto se utilizan únicamente para procesar tus compras y mejorar nuestro servicio.</li>
                    <li>NeusPhone nunca compartirá tu información con terceros sin tu consentimiento.</li>
                    <li>Las transacciones de pago son procesadas mediante pasarelas seguras y encriptadas.</li>
                </ul>
            </section>

        </div>
        
        <div class="mt-10 text-center">
            <a href="{{ route('dashboard.main') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-bold transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver al inicio
            </a>
        </div>
    </div>
</div>
@endsection
