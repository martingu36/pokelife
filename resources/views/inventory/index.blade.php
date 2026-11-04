<x-app-layout>
    <div x-data="{ selectedPokemon: null }" class="max-w-7xl mx-auto space-y-6">

        <!-- Barra Superior: Resumen y Filtros -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div>
                <h2 class="font-pixel text-base text-slate-900 dark:text-poke-yellow">MI INVENTARIO POKÉMON</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $pokemons->count() }} Pokémon registrados</p>
            </div>

            <form method="GET" action="{{ route('inventory.index') }}" class="flex flex-wrap items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o apodo..." class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-100 rounded-xl px-3 py-2 text-xs focus:ring-poke-red focus:border-poke-red">
                
                @if(isset($availableTypes) && $availableTypes->count() > 0)
                    <select name="type" onchange="this.form.submit()" class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-100 rounded-xl px-3 py-2 text-xs focus:ring-poke-red focus:border-poke-red uppercase">
                        <option value="">Todos los Tipos</option>
                        @foreach($availableTypes as $t)
                            <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                @endif

                @if(request('search') || request('type'))
                    <a href="{{ route('inventory.index') }}" class="text-xs text-slate-400 hover:text-poke-red font-semibold">Limpiar</a>
                @endif
            </form>
        </div>

        @if($pokemons->isEmpty())
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-12 text-center text-xs text-slate-500 dark:text-slate-400">
                No se encontraron Pokémon en tu inventario.
            </div>
        @else
            <!-- Grid de Pokémon -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($pokemons as $pokemon)
                    <div @click="selectedPokemon = {{ json_encode($pokemon) }}" 
                         class="relative bg-white dark:bg-slate-900 border {{ $pokemon->is_favorite ? 'border-poke-yellow dark:border-poke-yellow/80' : 'border-slate-200 dark:border-slate-800' }} rounded-2xl p-4 flex flex-col items-center cursor-pointer hover:border-poke-red dark:hover:border-poke-red transition shadow-sm group">
                        
                        @if($pokemon->is_favorite)
                            <span class="absolute top-2 right-2 text-poke-yellow text-xs" title="Favorito">★</span>
                        @endif

                        @if($pokemon->is_shiny)
                            <span class="absolute top-2 left-2 text-amber-400 text-[10px] font-bold">✨</span>
                        @endif

                        <img src="{{ $pokemon->sprite_url }}" class="w-20 h-20 object-contain group-hover:scale-105 transition">
                        
                        <p class="font-pixel text-[11px] text-slate-900 dark:text-slate-100 mt-2 text-center truncate max-w-full">
                            {{ $pokemon->nickname ?: $pokemon->name }}
                        </p>
                        <span class="text-[10px] text-slate-500 font-semibold">Nivel {{ $pokemon->level }}</span>

                        <div class="flex flex-wrap justify-center gap-1 mt-2">
                            @foreach($pokemon->types as $t)
                                <x-pokemon-type-badge :type="$t" />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Modal Interactivo con Estadísticas y Opciones -->
        <div x-show="selectedPokemon" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-sm p-4">
            <div @click.away="selectedPokemon = null" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl max-w-xl w-full p-6 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
                
                <div class="flex justify-between items-start border-b border-slate-200 dark:border-slate-800 pb-4">
                    <div class="flex items-center gap-4">
                        <img :src="selectedPokemon?.sprite_url" class="w-20 h-20 object-contain drop-shadow">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-pixel text-lg text-slate-900 dark:text-poke-yellow" x-text="selectedPokemon?.nickname || selectedPokemon?.name"></h3>
                                <template x-if="selectedPokemon?.gender === 'male'"><span class="text-blue-500 font-bold text-sm">♂</span></template>
                                <template x-if="selectedPokemon?.gender === 'female'"><span class="text-pink-500 font-bold text-sm">♀</span></template>
                                <template x-if="selectedPokemon?.is_shiny"><span class="text-amber-400 text-xs">✨ Shiny</span></template>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5" x-text="'Especie: ' + selectedPokemon?.name + ' • Nvl ' + selectedPokemon?.level"></p>
                            <p class="text-[10px] text-slate-400 mt-0.5" x-text="selectedPokemon?.category"></p>
                        </div>
                    </div>
                    <button @click="selectedPokemon = null" class="text-slate-400 hover:text-slate-600 dark:hover:text-white font-bold text-lg">&times;</button>
                </div>

                <!-- Tipos & Debilidades -->
                <div class="grid grid-cols-2 gap-4 text-xs bg-slate-50 dark:bg-slate-950 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
                    <div>
                        <span class="text-slate-400 uppercase font-bold text-[10px] block mb-2">Tipos</span>
                        <div class="flex flex-wrap gap-1">
                            <template x-for="t in selectedPokemon?.types" :key="t">
                                <span class="px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-800 text-slate-800 dark:text-slate-200 uppercase text-[10px] font-bold" x-text="t"></span>
                            </template>
                        </div>
                    </div>
                    <div>
                        <span class="text-slate-400 uppercase font-bold text-[10px] block mb-2">Debilidades (x2)</span>
                        <div class="flex flex-wrap gap-1">
                            <template x-for="w in selectedPokemon?.weaknesses" :key="w">
                                <span class="px-2 py-0.5 rounded bg-red-100 dark:bg-red-950/60 text-red-600 dark:text-red-300 uppercase text-[10px] font-bold" x-text="w"></span>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas Base (Valores individuales aplanados) -->
                <div class="space-y-3">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 dark:text-slate-100">Estadísticas Base</h4>
                    
                    <div class="space-y-2 text-xs">
                        <div>
                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                <span class="text-slate-500">Puntos de Salud (PS)</span>
                                <span class="text-slate-900 dark:text-white font-bold" x-text="selectedPokemon?.hp"></span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-300" :style="'width: ' + Math.min(100, (selectedPokemon?.hp / 255) * 100) + '%'"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                <span class="text-slate-500">Ataque</span>
                                <span class="text-slate-900 dark:text-white font-bold" x-text="selectedPokemon?.attack"></span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-amber-500 h-full rounded-full transition-all duration-300" :style="'width: ' + Math.min(100, (selectedPokemon?.attack / 255) * 100) + '%'"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                <span class="text-slate-500">Defensa</span>
                                <span class="text-slate-900 dark:text-white font-bold" x-text="selectedPokemon?.defense"></span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-full rounded-full transition-all duration-300" :style="'width: ' + Math.min(100, (selectedPokemon?.defense / 255) * 100) + '%'"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                <span class="text-slate-500">Ataque Especial</span>
                                <span class="text-slate-900 dark:text-white font-bold" x-text="selectedPokemon?.special_attack"></span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-purple-500 h-full rounded-full transition-all duration-300" :style="'width: ' + Math.min(100, (selectedPokemon?.special_attack / 255) * 100) + '%'"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                <span class="text-slate-500">Defensa Especial</span>
                                <span class="text-slate-900 dark:text-white font-bold" x-text="selectedPokemon?.special_defense"></span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-indigo-500 h-full rounded-full transition-all duration-300" :style="'width: ' + Math.min(100, (selectedPokemon?.special_defense / 255) * 100) + '%'"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                <span class="text-slate-500">Velocidad</span>
                                <span class="text-slate-900 dark:text-white font-bold" x-text="selectedPokemon?.speed"></span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-pink-500 h-full rounded-full transition-all duration-300" :style="'width: ' + Math.min(100, (selectedPokemon?.speed / 255) * 100) + '%'"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones (Cambio de Mote, Favorito y Liberar) -->
                <div class="border-t border-slate-200 dark:border-slate-800 pt-4 space-y-4">
                    <form :action="'/inventory/' + selectedPokemon?.id + '/nickname'" method="POST" class="flex gap-2">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="nickname" :value="selectedPokemon?.nickname" placeholder="Nuevo mote..." maxlength="20" class="flex-1 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-900 dark:text-white focus:ring-poke-red focus:border-poke-red">
                        <button type="submit" class="bg-slate-900 dark:bg-slate-800 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-800 dark:hover:bg-slate-700 transition">
                            Guardar
                        </button>
                    </form>

                    <div class="flex gap-2 pt-2">
                        <form :action="'/inventory/' + selectedPokemon?.id + '/favorite'" method="POST" class="w-1/2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full py-2.5 rounded-xl border text-xs font-bold transition flex items-center justify-center gap-1.5" :class="selectedPokemon?.is_favorite ? 'border-amber-400 text-amber-500 bg-amber-50 dark:bg-amber-950/30' : 'border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300'">
                                <span x-text="selectedPokemon?.is_favorite ? '★ Quitar Favorito' : '☆ Marcar Favorito'"></span>
                            </button>
                        </form>

                        <form :action="'/inventory/' + selectedPokemon?.id" method="POST" class="w-1/2" onsubmit="return confirm('¿Seguro que deseas liberar este Pokémon?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/50 py-2.5 rounded-xl text-xs font-bold hover:bg-red-100 dark:hover:bg-red-900/60 transition">
                                Liberar Pokémon
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>