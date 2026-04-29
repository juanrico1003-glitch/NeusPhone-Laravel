@extends('layouts.tienda')

@section('contenido')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-3xl p-8 md:p-12 border border-blue-100">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-5xl font-extrabold text-[#004080] mb-4">Términos y Condiciones</h1>
            <p class="text-lg text-blue-600 font-medium">Reglas claras para una excelente experiencia.</p>
        </div>

        <div class="space-y-6 text-gray-700 leading-relaxed text-justify">
            
            <p>
                Al acceder y utilizar la plataforma de <strong>NeusPhone</strong>, aceptas los siguientes términos y condiciones. Si no estás de acuerdo con alguna parte de los términos, te pedimos no utilizar nuestros servicios.
            </p>

            <div class="space-y-4">
                <h3 class="text-xl font-bold text-gray-800">1. Condiciones de Venta</h3>
                <p>Todos los precios mostrados en la plataforma incluyen los impuestos de ley vigentes. La disponibilidad de los productos está sujeta a nuestro inventario, en caso de que adquieras un producto que ya no esté en stock, te realizaremos el reembolso completo de inmediato.</p>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold text-gray-800">2. Servicio Técnico</h3>
                <p>Al dejar tu dispositivo en servicio técnico, aceptas que:</p>
                <ul class="list-disc pl-6 space-y-1 marker:text-blue-500">
                    <li>Es responsabilidad del cliente realizar copias de seguridad de sus datos personales. NeusPhone no se hace responsable por la pérdida de información.</li>
                    <li>Todo diagnóstico tiene un costo, el cual es descontado si apruebas la reparación final.</li>
                    <li>Equipos dejados en abandono por más de 60 días sin ser reclamados, podrán ser desechados o tomados como parte de pago de repuestos.</li>
                </ul>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold text-gray-800">3. Compras y Devoluciones</h3>
                <p>El cliente dispone de un plazo de 5 días hábiles después de recibir el producto para notificar cualquier defecto estético o funcional grave no reportado inicialmente. En caso de aplicar una devolución, el producto debe ser regresado con todos sus accesorios y cajas originales en buen estado.</p>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold text-gray-800">4. Propiedad Intelectual</h3>
                <p>Todo el contenido de este sitio (logos, textos, imágenes, diseños) es propiedad exclusiva de NeusPhone y está protegido por las leyes de propiedad intelectual correspondientes. Se prohíbe su reproducción sin autorización previa.</p>
            </div>

        </div>

        <div class="mt-10 pt-6 border-t border-gray-200 text-center">
            <a href="{{ route('dashboard.main') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-bold transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver al inicio
            </a>
        </div>
    </div>
</div>
@endsection
