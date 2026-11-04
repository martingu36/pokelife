<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Mensaje de fallo al intentar capturar -->
        @if (session('capture_failed'))
            <div
                class="bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-2xl flex items-center justify-between text-sm">
                <span>¡El Pokémon se ha escapado de la Pokéball! Inténtalo de nuevo o busca otro salvaje.</span>
                <form method="POST" action="{{ route('wild.encounter') }}">
                    @csrf
                    <button type="submit" class="font-bold underline hover:text-red-300">Buscar otro</button>
                </form>
            </div>
        @endif

        <!-- Card Principal del Pokémon Salvaje -->
        <div
            class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden">

            @if ($wildPokemon['is_shiny'] ?? false)
                <div
                    class="absolute top-4 left-4 bg-amber-400/20 border border-amber-400/40 text-amber-300 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-widest animate-pulse">
                    ★ ¡SHINY DETECTADO!
                </div>
            @endif

            <div class="flex flex-col md:flex-row items-center gap-8">
                <!-- Visualización del Sprite -->
                <div
                    class="flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-950/60 rounded-2xl p-6 border border-slate-100 dark:border-slate-800/80 w-full md:w-1/2">
                    <img src="{{ $wildPokemon['sprite_url'] }}" alt="{{ $wildPokemon['name'] }}"
                        class="w-48 h-48 sm:w-56 sm:h-56 object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-300">

                    <div class="flex items-center gap-2 mt-3">
                        <span class="text-xs text-slate-400 font-semibold">Nivel {{ $wildPokemon['level'] }}</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-xs text-slate-400">{{ $wildPokemon['height'] }} m</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-xs text-slate-400">{{ $wildPokemon['weight'] }} kg</span>
                    </div>
                </div>

                <!-- Detalles y Acciones -->
                <div class="w-full md:w-1/2 space-y-6">
                    <div>
                        <div class="flex items-center gap-3">
                            <h2 class="font-pixel text-xl sm:text-2xl text-slate-900 dark:text-poke-yellow">
                                {{ $wildPokemon['name'] }}
                            </h2>
                            @if (($wildPokemon['gender'] ?? '') === 'male')
                                <span class="text-blue-400 font-bold text-lg">♂</span>
                            @elseif(($wildPokemon['gender'] ?? '') === 'female')
                                <span class="text-pink-400 font-bold text-lg">♀</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $wildPokemon['category'] }}</p>
                    </div>

                    <!-- Tipos y Debilidades -->
                    <div class="space-y-3">
                        <div>
                            <span
                                class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1.5">Tipos</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach ($wildPokemon['types'] as $t)
                                    <x-pokemon-type-badge :type="$t" />
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <span
                                class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1.5">Debilidades</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach ($wildPokemon['weaknesses'] as $w)
                                    <x-pokemon-type-badge :type="$w" />
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción / Lanzar Pokéball -->
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80 space-y-3">
                        <form method="POST" action="{{ route('wild.catch') }}" class="space-y-4">
                            @csrf
                            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">
                                Selecciona tu Pokéball
                            </label>

                            @php
                                $balls = [
                                    'pokeball' => [
                                        'name' => 'Pokéball',
                                        'rate' => '50%',
                                        'color' => 'text-emerald-500',
                                        'sprite' =>
                                            'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png',
                                    ],
                                    'greatball' => [
                                        'name' => 'Superball',
                                        'rate' => '70%',
                                        'color' => 'text-blue-500',
                                        'sprite' =>
                                            'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/great-ball.png',
                                    ],
                                    'ultraball' => [
                                        'name' => 'Ultraball',
                                        'rate' => '85%',
                                        'color' => 'text-amber-500',
                                        'sprite' =>
                                            'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/ultra-ball.png',
                                    ],
                                    'masterball' => [
                                        'name' => 'Masterball',
                                        'rate' => '100%',
                                        'color' => 'text-purple-500',
                                        'sprite' =>
                                            'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/master-ball.png',
                                    ],
                                ];
                            @endphp

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach ($balls as $key => $ball)
                                    <label
                                        class="cursor-pointer border border-slate-200 dark:border-slate-800 rounded-2xl p-3 flex flex-col items-center justify-between hover:border-poke-red dark:hover:border-poke-red transition bg-slate-50/50 dark:bg-slate-950/40 relative group">
                                        <input type="radio" name="ball_type" value="{{ $key }}"
                                            {{ $loop->first ? 'checked' : '' }}
                                            class="absolute top-2 right-2 text-poke-red focus:ring-poke-red">
                                        <img src="{{ $ball['sprite'] }}" alt="{{ $ball['name'] }}"
                                            class="w-10 h-10 object-contain my-1 group-hover:scale-110 transition-transform drop-shadow">
                                        <div class="text-center">
                                            <span
                                                class="text-xs font-bold text-slate-800 dark:text-slate-200 block">{{ $ball['name'] }}</span>
                                            <span
                                                class="text-[10px] {{ $ball['color'] }} font-extrabold">{{ $ball['rate'] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <button type="submit"
                                class="w-full bg-poke-red hover:bg-red-600 text-white font-bold py-3 px-4 rounded-xl text-xs uppercase tracking-wider transition shadow-lg shadow-red-500/20 active:scale-95">
                                Lanzar Pokéball
                            </button>
                        </form>

                        <form method="POST" action="{{ route('wild.encounter') }}">
                            @csrf
                            <button type="submit"
                                class="w-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold py-2.5 px-4 rounded-xl text-xs transition">
                                Huir / Buscar otro Pokémon
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Post-Captura Exitosa en resources/views/wild/index.blade.php -->

    @if (session('capture_success') && session('captured_pokemon'))
        @php $captured = session('captured_pokemon'); @endphp
        <div x-data="{ open: true }" x-show="open" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4">
            <div
                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl max-w-md w-full p-6 text-center shadow-2xl space-y-5">
                <div
                    class="w-16 h-16 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center mx-auto text-2xl">
                    ✓
                </div>

                <div>
                    <h3 class="font-pixel text-lg text-slate-900 dark:text-poke-yellow">
                        ¡{{ data_get($captured, 'name') }} CAPTURADO!
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Se ha añadido correctamente a tu
                        inventario.</p>
                </div>

                <img src="{{ data_get($captured, 'sprite_url') }}" class="w-32 h-32 object-contain mx-auto">

                <form method="POST" action="{{ route('inventory.nickname', data_get($captured, 'id')) }}"
                    class="space-y-3 pt-2">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label
                            class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1 text-left">Asignar
                            Apodo (Opcional)</label>
                        <input type="text" name="nickname" maxlength="20"
                            placeholder="{{ data_get($captured, 'name') }}"
                            class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-900 dark:text-slate-100 focus:ring-poke-red focus:border-poke-red">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-poke-red hover:bg-red-600 text-white font-bold py-2.5 rounded-xl text-xs uppercase tracking-wider transition">
                            Guardar
                        </button>
                        <button type="button" @click="open = false"
                            class="flex-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold py-2.5 rounded-xl text-xs uppercase tracking-wider transition">
                            Omitir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</x-app-layout>
