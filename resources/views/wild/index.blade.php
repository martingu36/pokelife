<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6" x-data="{ capturing: false, ballSelected: 'pokeball' }">
        
        <!-- Mensaje Error con Animación Shaking -->
        @if (session('error'))
            <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-800 dark:bg-red-900/80 dark:text-red-200 font-medium rounded-lg animate-bounce">
                💨 {{ session('error') }}
            </div>
        @endif

        <!-- Buscador -->
        <div class="bg-white dark:bg-slate-800 p-4 sm:p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-md">
            <form action="{{ route('wild.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ $search }}" placeholder="Nombre o ID de Pokémon..." class="flex-1 bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white rounded-lg text-sm focus:border-poke-yellow focus:ring-poke-yellow">
                <div class="flex gap-2">
                    <button type="submit" class="text-xs font-bold bg-poke-yellow text-slate-900 px-4 py-3 rounded-lg hover:bg-yellow-300 transition">Buscar</button>
                    <a href="{{ route('wild.index') }}" class="text-xs font-bold bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-3 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition flex items-center">Aleatorio</a>
                </div>
            </form>
        </div>

        @if ($pokemon)
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xl overflow-hidden grid md:grid-cols-2 p-6 gap-6 relative">
                
                <!-- Overlay Animación de Captura en Proceso -->
                <div x-show="capturing" x-cloak class="absolute inset-0 bg-slate-950/90 z-50 flex flex-col items-center justify-center space-y-4">
                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png" class="w-24 h-24 animate-spin">
                    <p class="font-pixel text-sm text-poke-yellow animate-pulse">¡Lanzando Pokéball...</p>
                </div>

                <!-- Columna Pokémon -->
                <div class="flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
                    <img src="{{ $pokemon['sprite'] }}" alt="{{ $pokemon['name'] }}" class="w-48 h-48 sm:w-56 sm:h-56 object-contain drop-shadow-xl hover:scale-105 transition-transform">
                    <h3 class="font-pixel text-lg sm:text-xl text-slate-900 dark:text-poke-yellow mt-3">{{ $pokemon['name'] }} #{{ $pokemon['id'] }}</h3>
                    
                    <div class="mt-2">
                        <x-type-badge :types="$pokemon['types']" />
                    </div>

                    <div class="w-full grid grid-cols-2 gap-2 mt-4 text-xs text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 p-3 rounded-lg border border-slate-200 dark:border-slate-700">
                        <div><span class="font-semibold text-slate-500">Altura:</span> {{ $pokemon['height'] }} m</div>
                        <div><span class="font-semibold text-slate-500">Peso:</span> {{ $pokemon['weight'] }} kg</div>
                    </div>
                </div>

                <!-- Columna Formulario con Pokéballs visuales -->
                <div class="flex flex-col justify-between space-y-4">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-200 uppercase tracking-wide">Selecciona Pokéball</h4>
                    
                    <form action="{{ route('wild.catch') }}" method="POST" @submit="capturing = true" class="space-y-4">
                        @csrf
                        <input type="hidden" name="pokeapi_id" value="{{ $pokemon['id'] }}">
                        <input type="hidden" name="name" value="{{ $pokemon['name'] }}">
                        <input type="hidden" name="types" value="{{ $pokemon['types'] }}">
                        <input type="hidden" name="sprite_url" value="{{ $pokemon['sprite'] }}">

                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Mote (Opcional):</label>
                            <input type="text" name="nickname" placeholder="Ej: Rayito" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white rounded-lg text-sm">
                        </div>

                        <!-- Selector Gráfico de Pokéballs sin Radio Buttons visible -->
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Pokéball -->
                            <label @click="ballSelected = 'pokeball'" :class="ballSelected === 'pokeball' ? 'border-poke-red bg-red-50 dark:bg-red-950/30 ring-2 ring-poke-red' : 'border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900'" class="border rounded-xl p-3 flex items-center gap-3 cursor-pointer transition">
                                <input type="radio" name="pokeball_type" value="pokeball" class="sr-only" checked>
                                <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png" class="w-8 h-8 object-contain">
                                <div>
                                    <p class="text-xs font-bold text-slate-800 dark:text-slate-200">Pokéball</p>
                                    <p class="text-[10px] text-slate-500">Prob. 45%</p>
                                </div>
                            </label>

                            <!-- Superball -->
                            <label @click="ballSelected = 'superball'" :class="ballSelected === 'superball' ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/30 ring-2 ring-blue-500' : 'border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900'" class="border rounded-xl p-3 flex items-center gap-3 cursor-pointer transition">
                                <input type="radio" name="pokeball_type" value="superball" class="sr-only">
                                <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/great-ball.png" class="w-8 h-8 object-contain">
                                <div>
                                    <p class="text-xs font-bold text-blue-600 dark:text-blue-400">Superball</p>
                                    <p class="text-[10px] text-slate-500">Prob. 70%</p>
                                </div>
                            </label>

                            <!-- Ultraball -->
                            <label @click="ballSelected = 'ultraball'" :class="ballSelected === 'ultraball' ? 'border-yellow-500 bg-yellow-50 dark:bg-yellow-950/30 ring-2 ring-yellow-500' : 'border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900'" class="border rounded-xl p-3 flex items-center gap-3 cursor-pointer transition">
                                <input type="radio" name="pokeball_type" value="ultraball" class="sr-only">
                                <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/ultra-ball.png" class="w-8 h-8 object-contain">
                                <div>
                                    <p class="text-xs font-bold text-yellow-600 dark:text-yellow-400">Ultraball</p>
                                    <p class="text-[10px] text-slate-500">Prob. 88%</p>
                                </div>
                            </label>

                            <!-- Masterball -->
                            <label @click="ballSelected = 'masterball'" :class="ballSelected === 'masterball' ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/30 ring-2 ring-purple-500' : 'border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900'" class="border rounded-xl p-3 flex items-center gap-3 cursor-pointer transition">
                                <input type="radio" name="pokeball_type" value="masterball" class="sr-only">
                                <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/master-ball.png" class="w-8 h-8 object-contain">
                                <div>
                                    <p class="text-xs font-bold text-purple-600 dark:text-purple-400">Masterball</p>
                                    <p class="text-[10px] text-slate-500">Prob. 100%</p>
                                </div>
                            </label>
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-poke-red hover:bg-poke-darkred text-white font-bold text-sm rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                            <span>¡LANZAR POKÉBALL!</span>
                        </button>
                    </form>

                    <a href="{{ route('wild.index') }}" class="block w-full text-center py-2.5 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200 font-bold text-xs rounded-xl shadow transition">
                        🏃‍♂️ HUIR DE LA BATALLA
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>