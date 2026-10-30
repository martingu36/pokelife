<nav x-data="{ open: false }" class="bg-poke-red border-b-4 border-slate-950 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('welcome') }}">
                    <x-application-logo />
                </a>

                <!-- Navegación Escritorio -->
                <div class="hidden sm:flex sm:items-center sm:space-x-4">
                    <a href="{{ route('wild.index') }}" class="font-pixel text-xs px-3 py-2 rounded-md transition {{ request()->routeIs('wild.index') ? 'bg-slate-950 text-poke-yellow font-bold' : 'text-white hover:bg-poke-darkred' }}">
                        🌲 ZONA SALVAJE
                    </a>
                    <a href="{{ route('inventory.index') }}" class="font-pixel text-xs px-3 py-2 rounded-md transition {{ request()->routeIs('inventory.index') ? 'bg-slate-950 text-poke-yellow font-bold' : 'text-white hover:bg-poke-darkred' }}">
                        🎒 MI INVENTARIO
                    </a>
                </div>
            </div>

            <!-- Ajustes de Usuario / Logout -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-slate-900 font-pixel text-xs rounded-md text-white bg-slate-950 hover:bg-slate-900 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Botón Hamburguesa Móvil -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-poke-darkred focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú Desplegable Móvil -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-950 p-4 space-y-2">
        <a href="{{ route('wild.index') }}" class="block font-pixel text-xs text-white py-2">🌲 ZONA SALVAJE</a>
        <a href="{{ route('inventory.index') }}" class="block font-pixel text-xs text-white py-2">🎒 MI INVENTARIO</a>
        <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-slate-800">
            @csrf
            <button type="submit" class="font-pixel text-xs text-red-400">CERRAR SESIÓN</button>
        </form>
    </div>
</nav>