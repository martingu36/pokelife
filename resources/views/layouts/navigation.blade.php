<!-- resources/views/layouts/navigation.blade.php -->

<nav x-data="{ open: false }" class="bg-blue-600 dark:bg-blue-700 border-b border-blue-700/60 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('wild.index') }}" class="flex items-center gap-2.5 group">
                        <img 
                            src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png" 
                            alt="Pokéball" 
                            class="w-6 h-6 object-contain group-hover:rotate-12 transition-transform duration-300"
                        >
                        <span class="font-pixel text-amber-300 group-hover:text-amber-200 text-xs tracking-wider">
                            POKÉLIFE
                        </span>
                    </a>
                </div>

                <!-- Enlaces de Navegación -->
                <div class="hidden space-x-1 sm:flex sm:items-center">
                    <a href="{{ route('wild.index') }}" 
                       class="px-3.5 py-1.5 rounded-lg text-xs font-semibold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('wild.*') ? 'bg-black/20 text-amber-300' : 'text-red-100 hover:text-white hover:bg-white/10' }}">
                        Zona Salvaje
                    </a>

                    <a href="{{ route('inventory.index') }}" 
                       class="px-3.5 py-1.5 rounded-lg text-xs font-semibold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('inventory.*') ? 'bg-black/20 text-amber-300' : 'text-red-100 hover:bg-white/10 hover:text-white' }}">
                        Mi Inventario
                    </a>
                </div>
            </div>

            <!-- Menú de Usuario (Escritorio) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-white hover:bg-white/10 focus:outline-none transition-colors duration-200">
                            <span class="w-6 h-6 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-[10px] uppercase">
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </span>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="Route::has('profile.edit') ? route('profile.edit') : '#'">
                            Perfil de Entrenador
                        </x-dropdown-link>

                        <!-- Cerrar Sesión -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar Sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Botón Hamburguesa (Móvil) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-red-100 hover:text-white hover:bg-white/10 focus:outline-none transition-colors duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'inline-flex': open, 'hidden': ! open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú Responsive (Móvil) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-red-700/95 border-t border-red-700/60">
        <div class="py-2 space-y-1 px-4">
            <a href="{{ route('wild.index') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('wild.*') ? 'bg-black/20 text-amber-300' : 'text-red-100 hover:bg-white/10 hover:text-white' }}">
                Zona Salvaje
            </a>
            <a href="{{ route('inventory.index') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider transition-colors duration-200 {{ request()->routeIs('inventory.*') ? 'bg-black/20 text-amber-300' : 'text-red-100 hover:bg-white/10 hover:text-white' }}">
                Mi Inventario
            </a>
        </div>

        <div class="pt-3 pb-3 border-t border-red-700/60 px-4">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-6 h-6 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-[10px] uppercase">
                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                </span>
                <div>
                    <div class="font-bold text-xs text-white">{{ Auth::user()->name }}</div>
                    <div class="font-normal text-[11px] text-red-200">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-2 space-y-1">
                <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}" class="block text-xs text-red-100 hover:text-white font-medium py-1">
                    Perfil de Entrenador
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left text-xs text-red-200 hover:text-white font-medium py-1">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>