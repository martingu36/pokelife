<nav class="bg-white dark:bg-slate-900 border-t-4 border-poke-red border-b border-slate-200 dark:border-slate-800 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center">
                    <x-application-logo />
                </a>

                <!-- Pestañas de Navegación con Rojo Suave -->
                <div class="hidden sm:flex sm:items-center sm:space-x-2">
                    <a href="{{ route('home') }}" 
                       class="text-xs uppercase tracking-wider px-3.5 py-2 rounded-lg transition font-semibold {{ request()->routeIs('home') ? 'bg-red-50 text-poke-red dark:bg-red-950/40 dark:text-poke-yellow dark:border-red-900/50' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white border border-transparent' }}">
                        Inicio
                    </a>
                    <a href="{{ route('wild.index') }}" 
                       class="text-xs uppercase tracking-wider px-3.5 py-2 rounded-lg transition font-semibold {{ request()->routeIs('wild.index') ? 'bg-red-50 text-poke-red dark:bg-red-950/40 dark:text-poke-yellow dark:border-red-900/50' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white border border-transparent' }}">
                        Zona Salvaje
                    </a>
                    <a href="{{ route('inventory.index') }}" 
                       class="text-xs uppercase tracking-wider px-3.5 py-2 rounded-lg transition font-semibold {{ request()->routeIs('inventory.index') ? 'bg-red-50 text-poke-red dark:bg-red-950/40 dark:text-poke-yellow dark:border-red-900/50' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white border border-transparent' }}">
                        Inventario
                    </a>
                </div>
            </div>

            <!-- Menú Derecho: Switcher + Usuario -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <button @click="darkMode = !darkMode" 
                        type="button" 
                        class="p-2 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-xs font-semibold border border-slate-200 dark:border-slate-800 transition flex items-center gap-1.5"
                        title="Cambiar Modo Claro/Oscuro">
                    <span x-show="!darkMode">Modo Oscuro</span>
                    <span x-show="darkMode" x-cloak>Modo Claro</span>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-slate-200 dark:border-slate-800 text-xs font-semibold rounded-lg text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ms-1.5 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">
                            {{ __('Perfil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Botón Móvil -->
            <div class="flex items-center gap-2 sm:hidden">
                <button @click="darkMode = !darkMode" type="button" class="p-2 text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 rounded-lg text-xs">
                    <span x-show="!darkMode">Oscuro</span>
                    <span x-show="darkMode" x-cloak>Claro</span>
                </button>
                <button @click="open = ! open" class="p-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú Móvil -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4 pt-2 pb-4 space-y-2">
        <a href="{{ route('home') }}" class="block text-xs uppercase font-semibold text-slate-700 dark:text-slate-300 py-2">Inicio</a>
        <a href="{{ route('wild.index') }}" class="block text-xs uppercase font-semibold text-slate-700 dark:text-slate-300 py-2">Zona Salvaje</a>
        <a href="{{ route('inventory.index') }}" class="block text-xs uppercase font-semibold text-slate-700 dark:text-slate-300 py-2">Inventario</a>
        <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-slate-200 dark:border-slate-800">
            @csrf
            <button type="submit" class="text-xs uppercase font-semibold text-red-600 dark:text-red-400">Cerrar Sesión</button>
        </form>
    </div>
</nav>