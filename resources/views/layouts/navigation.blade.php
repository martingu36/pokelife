<nav x-data="{ open: false }" class="bg-poke-red border-b-4 border-slate-950 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <a href="{{ route('welcome') }}">
                    <x-application-logo />
                </a>

                <!-- Enlaces Navegación -->
                <div class="hidden sm:flex sm:items-center sm:space-x-3">
                    <a href="{{ route('home') }}"
                        class="text-sm font-semibold px-3 py-2 rounded-md transition {{ request()->routeIs('home') ? 'bg-slate-950 text-poke-yellow' : 'text-white hover:bg-poke-darkred' }}">
                        🏠 Centro Entrenador
                    </a>
                    <a href="{{ route('wild.index') }}"
                        class="text-sm font-semibold px-3 py-2 rounded-md transition {{ request()->routeIs('wild.index') ? 'bg-slate-950 text-poke-yellow' : 'text-white hover:bg-poke-darkred' }}">
                        🌲 Zona Salvaje
                    </a>
                    <a href="{{ route('inventory.index') }}"
                        class="text-sm font-semibold px-3 py-2 rounded-md transition {{ request()->routeIs('inventory.index') ? 'bg-slate-950 text-poke-yellow' : 'text-white hover:bg-poke-darkred' }}">
                        🎒 Mi Inventario
                    </a>
                </div>
            </div>

            <!-- Botón Modo Claro/Oscuro + Dropdown Usuario -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <!-- Botón de cambio de tema -->
                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')"
                    type="button"
                    class="p-2 text-white bg-slate-950 hover:bg-slate-800 rounded-lg border border-slate-800 text-sm transition"
                    title="Cambiar Modo Claro/Oscuro">
                    <span x-show="!darkMode">🌙 Oscuro</span>
                    <span x-show="darkMode" x-cloak>☀️ Claro</span>
                </button>

                <!-- Menú de Usuario -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-slate-900 text-sm font-medium rounded-md text-white bg-slate-950 hover:bg-slate-800 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ms-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')"
                            class="text-slate-800 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700">
                            {{ __('Perfil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-slate-800 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Botón Hamburguesa Móvil -->
            <div class="flex items-center gap-2 sm:hidden">
                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')"
                    type="button" class="p-2 text-white bg-slate-950 rounded-lg text-xs">
                    <span x-show="!darkMode">🌙</span>
                    <span x-show="darkMode" x-cloak>☀️</span>
                </button>
                <button @click="open = ! open" class="p-2 rounded-md text-white hover:bg-poke-darkred">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú Móvil -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-slate-950 p-4 space-y-2">
        <a href="{{ route('wild.index') }}" class="block text-white py-2 font-medium">🌲 Zona Salvaje</a>
        <a href="{{ route('inventory.index') }}" class="block text-white py-2 font-medium">🎒 Mi Inventario</a>
        <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-slate-800">
            @csrf
            <button type="submit" class="text-red-400 font-medium">Cerrar Sesión</button>
        </form>
    </div>
</nav>
