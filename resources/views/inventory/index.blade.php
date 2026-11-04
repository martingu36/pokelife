<x-app-layout>
    <div x-cloak class="max-w-7xl mx-auto space-y-6">

        <!-- Barra Superior: Resumen y Filtros -->
        <div
            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div>
                <h2 class="font-pixel text-base text-slate-900 dark:text-poke-yellow">MI INVENTARIO POKÉMON</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    {{ $pokemons->count() }} Pokémon registrados
                </p>
            </div>

            <form method="GET" action="{{ route('inventory.index') }}" class="flex flex-wrap items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Buscar por nombre o apodo..."
                    class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-100 rounded-xl px-3 py-2 text-xs focus:ring-poke-red focus:border-poke-red">

                @if (isset($availableTypes) && $availableTypes->count() > 0)
                    <select name="type" onchange="this.form.submit()"
                        class="appearance-none bg-none bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200 rounded-xl px-3.5 py-2 text-xs font-semibold uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-red-500/50 cursor-pointer shadow-sm transition-colors">
                        <option value="" class="bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200">
                            Todos los Tipos
                        </option>
                        @foreach ($availableTypes as $t)
                            <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}
                                class="bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200">
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                @endif

                @if (request('search') || request('type'))
                    <a href="{{ route('inventory.index') }}"
                        class="text-xs text-slate-400 hover:text-poke-red font-semibold">Limpiar</a>
                @endif
            </form>
        </div>

        @if ($pokemons->isEmpty())
            <div
                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-12 text-center text-xs text-slate-500 dark:text-slate-400">
                No se encontraron Pokémon en tu inventario.
            </div>
        @else
            <!-- Grid de Pokémon -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach ($pokemons as $pokemon)
                    <div x-data="{ open: false }">

                        <!-- Tarjeta de Selección -->
                        <div @click="open = true"
                            class="relative bg-white dark:bg-slate-900 border {{ $pokemon->is_favorite ? 'border-poke-yellow dark:border-poke-yellow/80' : 'border-slate-200 dark:border-slate-800' }} rounded-2xl p-4 flex flex-col items-center cursor-pointer hover:border-poke-red dark:hover:border-poke-red transition shadow-sm group">

                            @if ($pokemon->is_favorite)
                                <span class="absolute top-2 right-2 text-poke-yellow text-xs" title="Favorito">★</span>
                            @endif

                            @if ($pokemon->is_shiny)
                                <span class="absolute top-2 left-2 text-amber-400 text-[10px] font-bold">✨</span>
                            @endif

                            <img src="{{ $pokemon->sprite_url }}" alt="{{ $pokemon->name }}"
                                class="w-20 h-20 object-contain group-hover:scale-105 transition">

                            <p
                                class="font-pixel text-[11px] text-slate-900 dark:text-slate-100 mt-2 text-center truncate max-w-full">
                                {{ $pokemon->nickname ?: $pokemon->name }}
                            </p>
                            <span class="text-[10px] text-slate-500 font-semibold">Nivel {{ $pokemon->level }}</span>

                            <div class="flex flex-wrap justify-center gap-1 mt-2">
                                @if (is_array($pokemon->types))
                                    @foreach ($pokemon->types as $t)
                                        <x-pokemon-type-badge :type="$t" />
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Modal de Detalle de este Pokémon -->
                        <div x-show="open" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-sm p-4">
                            <div @click.away="open = false"
                                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl max-w-xl w-full p-6 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">

                                <!-- Encabezado del Modal -->
                                <div
                                    class="flex justify-between items-start border-b border-slate-200 dark:border-slate-800 pb-4">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $pokemon->sprite_url }}" alt="{{ $pokemon->name }}"
                                            class="w-20 h-20 object-contain drop-shadow">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-pixel text-lg text-slate-900 dark:text-poke-yellow">
                                                    {{ $pokemon->nickname ?: $pokemon->name }}
                                                </h3>
                                                @if ($pokemon->gender === 'male')
                                                    <span class="text-blue-500 font-bold text-sm">♂</span>
                                                @elseif ($pokemon->gender === 'female')
                                                    <span class="text-pink-500 font-bold text-sm">♀</span>
                                                @endif

                                                @if ($pokemon->is_shiny)
                                                    <span class="text-amber-400 text-xs">✨ Shiny</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                                Especie: {{ $pokemon->name }} • Nvl {{ $pokemon->level }}
                                            </p>
                                            @if ($pokemon->category)
                                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $pokemon->category }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <button @click="open = false"
                                        class="text-slate-400 hover:text-slate-600 dark:hover:text-white font-bold text-lg">&times;</button>
                                </div>

                                <!-- Tipos & Debilidades -->
                                <div class="space-y-3">
                                    <div>
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1.5">
                                            Tipos
                                        </span>
                                        <div class="flex flex-wrap gap-1.5">
                                            @if (is_array($pokemon->types))
                                                @foreach ($pokemon->types as $t)
                                                    <x-pokemon-type-badge :type="$t" />
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    @if (!empty($pokemon->weaknesses) && is_array($pokemon->weaknesses))
                                        <div>
                                            <span
                                                class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1.5">
                                                Debilidades
                                            </span>
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach ($pokemon->weaknesses as $w)
                                                    <x-pokemon-type-badge :type="$w" />
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Estadísticas Base -->
                                <div class="space-y-3">
                                    <h4
                                        class="font-bold text-xs uppercase tracking-wider text-slate-900 dark:text-slate-100">
                                        Estadísticas Base
                                    </h4>

                                    <div class="space-y-2 text-xs">
                                        <div>
                                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                                <span class="text-slate-500">Puntos de Salud (PS)</span>
                                                <span
                                                    class="text-slate-900 dark:text-white font-bold">{{ $pokemon->hp }}</span>
                                            </div>
                                            <div
                                                class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-300"
                                                    style="width: {{ min(100, ($pokemon->hp / 255) * 100) }}%"></div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                                <span class="text-slate-500">Ataque</span>
                                                <span
                                                    class="text-slate-900 dark:text-white font-bold">{{ $pokemon->attack }}</span>
                                            </div>
                                            <div
                                                class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                                <div class="bg-amber-500 h-full rounded-full transition-all duration-300"
                                                    style="width: {{ min(100, ($pokemon->attack / 255) * 100) }}%">
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                                <span class="text-slate-500">Defensa</span>
                                                <span
                                                    class="text-slate-900 dark:text-white font-bold">{{ $pokemon->defense }}</span>
                                            </div>
                                            <div
                                                class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                                <div class="bg-blue-500 h-full rounded-full transition-all duration-300"
                                                    style="width: {{ min(100, ($pokemon->defense / 255) * 100) }}%">
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                                <span class="text-slate-500">Ataque Especial</span>
                                                <span
                                                    class="text-slate-900 dark:text-white font-bold">{{ $pokemon->special_attack }}</span>
                                            </div>
                                            <div
                                                class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                                <div class="bg-purple-500 h-full rounded-full transition-all duration-300"
                                                    style="width: {{ min(100, ($pokemon->special_attack / 255) * 100) }}%">
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                                <span class="text-slate-500">Defensa Especial</span>
                                                <span
                                                    class="text-slate-900 dark:text-white font-bold">{{ $pokemon->special_defense }}</span>
                                            </div>
                                            <div
                                                class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                                <div class="bg-indigo-500 h-full rounded-full transition-all duration-300"
                                                    style="width: {{ min(100, ($pokemon->special_defense / 255) * 100) }}%">
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                                <span class="text-slate-500">Velocidad</span>
                                                <span
                                                    class="text-slate-900 dark:text-white font-bold">{{ $pokemon->speed }}</span>
                                            </div>
                                            <div
                                                class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                                <div class="bg-pink-500 h-full rounded-full transition-all duration-300"
                                                    style="width: {{ min(100, ($pokemon->speed / 255) * 100) }}%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Acciones (Cambio de Mote, Favorito y Liberar) -->
                                <div class="border-t border-slate-200 dark:border-slate-800 pt-4 space-y-4">
                                    <form action="/inventory/{{ $pokemon->id }}/nickname" method="POST"
                                        class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="nickname" value="{{ $pokemon->nickname }}"
                                            placeholder="Nuevo mote..." maxlength="20"
                                            class="flex-1 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-900 dark:text-white focus:ring-poke-red focus:border-poke-red">
                                        <button type="submit"
                                            class="bg-slate-900 dark:bg-slate-800 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-800 dark:hover:bg-slate-700 transition">
                                            Guardar
                                        </button>
                                    </form>

                                    <div class="flex gap-2 pt-2">
                                        <form action="/inventory/{{ $pokemon->id }}/favorite" method="POST"
                                            class="w-1/2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="w-full py-2.5 rounded-xl border text-xs font-bold transition flex items-center justify-center gap-1.5 {{ $pokemon->is_favorite ? 'border-amber-400 text-amber-500 bg-amber-50 dark:bg-amber-950/30' : 'border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300' }}">
                                                <span>{{ $pokemon->is_favorite ? '★ Quitar Favorito' : '☆ Marcar Favorito' }}</span>
                                            </button>
                                        </form>

                                        <form action="/inventory/{{ $pokemon->id }}" method="POST" class="w-1/2"
                                            onsubmit="return confirm('¿Seguro que deseas liberar este Pokémon?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/50 py-2.5 rounded-xl text-xs font-bold hover:bg-red-100 dark:hover:bg-red-900/60 transition">
                                                Liberar Pokémon
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>
