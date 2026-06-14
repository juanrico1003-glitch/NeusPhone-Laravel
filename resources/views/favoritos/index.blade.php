<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#004080] leading-tight">Mis Favoritos</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-lg text-sm shadow-sm">{{ session('success') }}</div>
        @endif

        @forelse($favoritos as $fav)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 flex items-center justify-center">
                    @if(!empty($fav->producto->imagenes))
                    <img src="{{ asset('productos/'.$fav->producto->imagenes[0]) }}" class="object-contain w-14 h-14">
                    @endif
                </div>
                <div>
                    <a href="{{ route('tienda.producto', $fav->producto->id) }}" class="font-semibold text-gray-800 hover:text-blue-600">{{ $fav->producto->nombre }}</a>
                    <p class="text-sm text-green-600 font-bold">${{ number_format($fav->producto->precio, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('tienda.producto', $fav->producto->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">Ver</a>
                <form method="POST" action="{{ route('favoritos.toggle', $fav->producto->id) }}">
                    @csrf
                    <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-lg text-sm font-medium">Quitar</button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
            <p class="text-gray-500 font-semibold text-lg">No tienes productos favoritos</p>
            <a href="{{ route('tienda') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800 font-medium">Explorar productos →</a>
        </div>
        @endforelse
    </div>
</x-app-layout>
