<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Panel Administrativo</h2>
    </x-slot>

    <div class="p-4 sm:p-6 space-y-5 max-w-7xl mx-auto">

        {{-- Navegación rápida --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            <a href="{{ route('admin.productos.index') }}" class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md hover:border-blue-200 transition group">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Productos</p>
                    <p class="text-xs text-gray-400">{{ $totalProductos }} registrados</p>
                </div>
            </a>
            <a href="{{ route('admin.pedidos.index') }}" class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md hover:border-green-200 transition group">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Pedidos</p>
                    <p class="text-xs text-gray-400">{{ $pendientes }} pendientes</p>
                </div>
            </a>
            <a href="{{ route('admin.servicios.index') }}" class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md hover:border-yellow-200 transition group">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Servicios</p>
                    <p class="text-xs text-gray-400">{{ $serviciosPendientes }} pendientes</p>
                </div>
            </a>
            <a href="{{ route('admin.testimonios') }}" class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md hover:border-purple-200 transition group">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Testimonios</p>
                    <p class="text-xs text-gray-400">Gestionar reseñas</p>
                </div>
            </a>
            <a href="{{ route('admin.usuarios.index') }}" class="flex items-center gap-3 bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md hover:border-indigo-200 transition group">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Usuarios</p>
                    <p class="text-xs text-gray-400">{{ $totalUsuarios }} registrados</p>
                </div>
            </a>
        </div>

        {{-- Stats rápidas --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Ventas totales</p>
                        <p class="text-xl font-bold text-gray-800 mt-1">${{ number_format($ventas, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">${{ number_format($ventasMes, 0, ',', '.') }} este mes</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pedidos</p>
                        <p class="text-xl font-bold text-gray-800 mt-1">{{ $totalPedidos }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">{{ $pendientes }} pendientes · {{ $pagados }} pagados</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Productos</p>
                        <p class="text-xl font-bold text-gray-800 mt-1">{{ $totalProductos }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">{{ $productosActivos }} activos · {{ $sinStock }} sin stock</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Usuarios</p>
                        <p class="text-xl font-bold text-gray-800 mt-1">{{ $totalUsuarios }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">{{ $usuariosNuevosMes }} nuevos este mes</p>
            </div>
        </div>

        {{-- Gráficos compactos --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Ventas mensuales</h3>
                <div style="height: 180px">
                    <canvas id="graficoVentas"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Productos por categoría</h3>
                <div style="height: 180px">
                    <canvas id="graficoCategorias"></canvas>
                </div>
            </div>
        </div>

        {{-- Alerta stock bajo --}}
        @if($bajoStock->isNotEmpty() || $agotados->isNotEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-50">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 {{ $agotados->isNotEmpty() ? 'text-red-500' : 'text-yellow-500' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <h3 class="text-sm font-semibold text-gray-700">Stock crítico</h3>
                </div>
                <a href="{{ route('admin.productos.index') }}" class="text-xs font-medium text-blue-600 hover:text-blue-800">Ver todos →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-400 text-xs uppercase tracking-wide">
                            <th class="px-4 py-2.5 font-medium">Producto</th>
                            <th class="px-4 py-2.5 font-medium">Marca</th>
                            <th class="px-4 py-2.5 font-medium">Stock</th>
                            <th class="px-4 py-2.5 font-medium">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($agotados as $p)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-2.5 font-medium text-gray-800">{{ $p->nombre }}</td>
                            <td class="px-4 py-2.5 text-gray-500">{{ $p->marca }}</td>
                            <td class="px-4 py-2.5"><span class="font-bold text-red-600">0</span></td>
                            <td class="px-4 py-2.5"><span class="bg-red-50 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">Agotado</span></td>
                        </tr>
                        @endforeach
                        @foreach($bajoStock as $p)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-2.5 font-medium text-gray-800">{{ $p->nombre }}</td>
                            <td class="px-4 py-2.5 text-gray-500">{{ $p->marca }}</td>
                            <td class="px-4 py-2.5"><span class="font-bold {{ $p->stock <= 2 ? 'text-red-600' : 'text-yellow-600' }}">{{ $p->stock }}</span></td>
                            <td class="px-4 py-2.5"><span class="bg-yellow-50 text-yellow-600 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">Stock bajo</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Más vendidos · Más vistos · Top clientes --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    Más vendidos
                </h3>
                @if($masVendidos->isNotEmpty())
                <div class="space-y-2">
                    @foreach($masVendidos as $i => $item)
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold flex items-center justify-center shrink-0">{{ $i + 1 }}</span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-gray-800 truncate">{{ $item->producto?->nombre ?? 'Eliminado' }}</p>
                            <p class="text-[10px] text-gray-400">{{ $item->total_vendido }} uds</p>
                        </div>
                        <span class="text-[10px] font-semibold text-gray-600">${{ number_format($item->total_ingresos ?? 0, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-xs text-gray-400">Sin ventas aún.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Más vistos
                </h3>
                @if($masVistos->isNotEmpty())
                <div class="space-y-2">
                    @foreach($masVistos as $i => $p)
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold flex items-center justify-center shrink-0">{{ $i + 1 }}</span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-gray-800 truncate">{{ $p->nombre }}</p>
                            <p class="text-[10px] text-gray-400">{{ number_format($p->visitas) }} visitas</p>
                        </div>
                        <span class="text-[10px] font-semibold text-gray-600">${{ number_format($p->precio, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-xs text-gray-400">Sin datos aún.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Top clientes
                </h3>
                @if($topClientes->isNotEmpty())
                <div class="space-y-2">
                    @foreach($topClientes as $i => $item)
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-green-50 text-green-600 text-[10px] font-bold flex items-center justify-center shrink-0">{{ $i + 1 }}</span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-gray-800 truncate">{{ $item->usuario?->nombres ?? 'Eliminado' }} {{ $item->usuario?->apellidos ?? '' }}</p>
                            <p class="text-[10px] text-gray-400">{{ $item->total_pedidos }} pedidos</p>
                        </div>
                        <span class="text-[10px] font-semibold text-gray-600">${{ number_format($item->total_gastado ?? 0, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-xs text-gray-400">Sin clientes aún.</p>
                @endif
            </div>
        </div>

        {{-- Pedidos recientes --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-50">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Pedidos recientes
                </h3>
                <a href="{{ route('admin.pedidos.index') }}" class="text-xs font-medium text-blue-600 hover:text-blue-800">Ver todos →</a>
            </div>
            @if($pedidosRecientes->isNotEmpty())
            <div class="divide-y divide-gray-50">
                @foreach($pedidosRecientes as $p)
                <a href="{{ route('admin.pedidos.show', $p) }}" class="flex items-center justify-between px-4 py-2.5 hover:bg-gray-50/50 transition">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="text-xs font-mono font-bold text-gray-400">#{{ $p->id }}</span>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $p->usuario?->nombres ?? 'Eliminado' }} {{ $p->usuario?->apellidos ?? '' }}</p>
                            <p class="text-[10px] text-gray-400">{{ $p->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <span class="text-sm font-semibold text-gray-700">${{ number_format($p->total, 0, ',', '.') }}</span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide
                            @if($p->estado === 'pendiente') bg-yellow-50 text-yellow-600
                            @elseif($p->estado === 'pagado') bg-green-50 text-green-600
                            @elseif($p->estado === 'cancelado') bg-red-50 text-red-600
                            @elseif($p->estado === 'enviado') bg-blue-50 text-blue-600
                            @else bg-gray-50 text-gray-600 @endif">
                            {{ $p->estado }}
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <p class="text-xs text-gray-400 p-4">Sin pedidos aún.</p>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        new Chart(document.getElementById('graficoVentas'), {
            type: 'bar',
            data: {
                labels: @json($meses),
                datasets: [{
                    label: 'Ventas',
                    data: @json($ventasArray),
                    backgroundColor: 'rgba(59, 130, 246, 0.4)',
                    borderColor: '#3b82f6',
                    borderWidth: 1.5,
                    borderRadius: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { font: { size: 9 }, callback: v => '$' + v.toLocaleString('es-CO') } },
                    x: { ticks: { font: { size: 9 } } }
                }
            }
        });

        @php
            $catLabels = $distribucionCategorias->pluck('categoria.nombre')->toArray();
            $catData = $distribucionCategorias->pluck('total')->toArray();
        @endphp
        new Chart(document.getElementById('graficoCategorias'), {
            type: 'doughnut',
            data: {
                labels: @json($catLabels),
                datasets: [{
                    data: @json($catData),
                    backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#14b8a6'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 10, padding: 8, font: { size: 9 } }
                    }
                }
            }
        });
    });
    </script>
</x-app-layout>
