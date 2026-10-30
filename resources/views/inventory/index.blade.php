<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-base text-slate-800 dark:text-slate-100">
                🎒 Mi Inventario de Pokémon
            </h2>
            <span class="text-xs bg-yellow-400 text-slate-900 px-3 py-1 rounded-full font-bold">
                Equipo Favorito: {{ $favoriteCount }} / 6
            </span>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        @if (session('success'))
            <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-800 dark:bg-green-900/80 dark:text-green-200 font-medium rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-800 dark:bg-red-900/80 dark:text-red-200 font-medium rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Barra de Filtros y Búsqueda -->
        <div class="bg-white dark:bg-slate-800 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-md">
            <form action="{{ route('inventory.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 items-center">
                <!-- Buscar por texto -->
                <div class="flex-1 w-full">
                    <input type="text" 
                           name="search" 
                           value="{{ $filters['search'] ?? '' }}" 
                           placeholder="Buscar por nombre o mote..." 
                           class="w-full bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl text-xs focus:border-poke-yellow focus:ring-poke-yellow">
                </div>

                <!-- Filtrar por Tipo -->
                <div class="w-full md:w-48">
                    <select name="type" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl text-xs focus:border-poke-yellow focus:ring-poke-yellow">
                        <option value="">Todos los tipos</option>
                        @foreach($availableTypes as $t)
                            <option value="{{ $t }}" {{ ($filters['type'] ?? '') === $t ? 'selected' : '' }}>
                                {{ ucfirst($t) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Interruptor Solo Favoritos -->
                <label class="flex items-center gap-2 cursor-pointer bg-slate-50 dark:bg-slate-900 px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 w-full md:w-auto">
                    <input type="checkbox" 
                           name="favorites" 
                           value="1" 
                           {{ !empty($filters['favorites']) ? 'checked' : '' }} 
                           class="rounded text-poke-yellow focus:ring-poke-yellow">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 whitespace-nowrap">⭐ Solo Favoritos</span>
                </label>

                <!-- Acciones -->
                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-initial text-xs font-bold bg-poke-yellow text-slate-900 px-4 py-2.5 rounded-xl hover:bg-yellow-300 transition">
                        Filtrar
                    </button>
                    @if(!empty($filters['search']) || !empty($filters['type']) || !empty($filters['favorites']))
                        <a href="{{ route('inventory.index') }}" class="flex-1 md:flex-initial text-xs font-bold text-center bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 px-4 py-2.5 rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($pokemons->isEmpty())
            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-200 dark:border-slate-700 text-center space-y-4">
                @if(!empty($filters['search']) || !empty($filters['type']) || !empty($filters['favorites']))
                    <p class="text-slate-500 dark:text-slate-400 text-base">No se han encontrado Pokémon en tu inventario que coincidan con los filtros.</p>
                    <a href="{{ route('inventory.index') }}" class="inline-block text-xs bg-slate-700 text-white font-bold px-4 py-2 rounded-xl">Limpiar Filtros</a>
                @else
                    <p class="text-slate-500 dark:text-slate-400 text-base">Aún no has capturado ningún Pokémon.</p>
                    <a href="{{ route('wild.index') }}" class="inline-block text-xs bg-poke-red text-white font-bold px-6 py-3 rounded-xl hover:bg-poke-darkred transition shadow-lg">Ir a la Zona Salvaje</a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pokemons as $p)
                    @php
                        $ballImages = [
                            'pokeball' => 'poke-ball.png',
                            'superball' => 'great-ball.png',
                            'ultraball' => 'ultra-ball.png',
                            'masterball' => 'master-ball.png',
                        ];
                        $ballImg = $ballImages[$p->pokeball_type] ?? 'poke-ball.png';
                    @endphp

                    <div x-data="{ releasing: false }" 
                         x-show="!releasing" 
                         x-transition:leave="transition ease-in duration-300 transform"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-75"
                         class="bg-white dark:bg-slate-800 rounded-2xl p-5 border-2 {{ $p->is_favorite ? 'border-yellow-400' : 'border-slate-200 dark:border-slate-700' }} relative shadow-xl flex flex-col justify-between">
                        
                        @if($p->is_favorite)
                            <span class="absolute top-3 right-3 text-xl" title="Equipo Favorito">⭐</span>
                        @endif

                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img src="{{ $p->sprite_url }}" alt="{{ $p->name }}" class="w-20 h-20 object-contain drop-shadow">
                                <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/{{ $ballImg }}" class="w-5 h-5 absolute bottom-0 right-0 bg-white dark:bg-slate-900 rounded-full p-0.5 border shadow" title="Capturado con {{ $p->pokeball_type }}">
                            </div>
                            
                            <div class="space-y-1">
                                <h3 class="font-pixel text-xs text-slate-900 dark:text-poke-yellow">{{ $p->nickname ?: $p->name }}</h3>
                                @if($p->nickname)
                                    <p class="text-[11px] text-slate-500">Especie: {{ $p->name }}</p>
                                @endif
                                <p class="text-xs font-semibold text-slate-600 dark:text-slate-300">Nivel {{ $p->level }}</p>
                                <x-type-badge :types="$p->types" />
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700 space-y-3">
                            <form action="{{ route('inventory.nickname', $p) }}" method="POST" class="flex gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="nickname" value="{{ $p->nickname }}" placeholder="Mote..." class="flex-1 bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white text-xs rounded-md">
                                <button type="submit" class="text-xs font-bold bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-1 rounded hover:bg-slate-300 dark:hover:bg-slate-600">OK</button>
                            </form>

                            <div class="flex justify-between items-center">
                                <form action="{{ route('inventory.favorite', $p) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs px-3 py-1.5 rounded-md font-bold {{ $p->is_favorite ? 'bg-yellow-400 text-slate-900' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200' }}">
                                        {{ $p->is_favorite ? '★ EN EQUIPO' : '☆ FAVORITO' }}
                                    </button>
                                </form>

                                <form action="{{ route('inventory.release', $p) }}" method="POST" @submit="if(confirm('¿Liberar a este Pokémon?')) { releasing = true } else { $event.preventDefault() }">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-50 text-red-700 dark:bg-red-950/60 dark:text-red-400 hover:bg-red-100 border border-red-200 dark:border-red-900 px-3 py-1.5 rounded-md font-bold">
                                        LIBERAR
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>