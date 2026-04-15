<nav x-data="{ open: false }" class="bg-white shadow-md border-b border-blue-100">

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition">
                    NeusPhone
                </a>

                <!-- Links -->
                <div class="hidden sm:flex space-x-6">
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Dashboard
                    </a>

                    <a href="{{ route('admin.productos.index') }}"
                       class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Productos
                    </a>

                    <a href="{{ route('admin.pedidos.index') }}"
                       class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Pedidos
                    </a>
                </div>
            </div>

            <!-- Usuario -->
            <div class="hidden sm:flex items-center space-x-4">

                <span class="text-gray-600 text-sm">
                    {{ Auth::user()->nombres ?? '' }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                        Cerrar sesión
                    </button>
                </form>

            </div>

            <!-- Botón móvil -->
            <div class="sm:hidden">
                <button @click="open = !open"
                        class="text-gray-600 hover:text-blue-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open}" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Menú móvil -->
    <div x-show="open" class="sm:hidden bg-white border-t border-blue-100">
        <div class="px-6 py-4 space-y-3">

            <a href="{{ route('admin.dashboard') }}"
               class="block text-gray-700 hover:text-blue-600">
                Dashboard
            </a>

            <a href="{{ route('admin.productos.index') }}"
               class="block text-gray-700 hover:text-blue-600">
                Productos
            </a>

            <a href="{{ route('admin.pedidos.index') }}"
               class="block text-gray-700 hover:text-blue-600">
                Pedidos
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left text-red-600">
                    Cerrar sesión
                </button>
            </form>

        </div>
    </div>

</nav>
