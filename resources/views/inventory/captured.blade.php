<x-app-layout>
    <div class="max-w-2xl mx-auto py-6" x-data="{ showCard: false }" x-init="setTimeout(() => showCard = true, 400)">
        
        <div x-show="showCard" 
             x-transition:enter="transition ease-out duration-700 transform" 
             x-transition:enter-start="opacity-0 scale-90 -translate-y-4" 
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white dark:bg-slate-800 border-2 border-poke-yellow rounded-2xl shadow-2xl overflow-hidden p-6 text-center space-y-6 relative">
            
            <div class="inline-block bg-yellow-400 text-slate-900 font-pixel text-xs px-4 py-2 rounded-full uppercase font-bold tracking-wider">
                🎉 ¡POKÉMON CAPTURADO CON ÉXITO!
            </div>

            <!-- Sprite del Pokémon capturado con Pokéball flotante -->
            <div class="relative bg-slate-50 dark:bg-slate-900/80 rounded-xl p-6 border border-slate-200 dark:border-slate-700 flex flex-col items-center">
                @php
                    $ballImages = [
                        'pokeball' => 'poke-ball.png',
                        'superball' => 'great-ball.png',
                        'ultraball' => 'ultra-ball.png',
                        'masterball' => 'master-ball.png',
                    ];
                    $ballImg = $ballImages[$pokemon->pokeball_type] ?? 'poke-ball.png';
                @endphp
                
                <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/{{ $ballImg }}" class="w-10 h-10 absolute top-4 right-4 animate-bounce">
                
                <img src="{{ $pokemon->sprite_url }}" alt="{{ $pokemon->name }}" class="w-48 h-48 object-contain drop-shadow-2xl">
                <h2 class="font-pixel text-2xl text-slate-900 dark:text-poke-yellow mt-2">{{ $pokemon->name }}</h2>
                <div class="mt-1">
                    <x-type-badge :types="$pokemon->types" />
                </div>
            </div>

            @if($details)
                <div class="grid grid-cols-3 gap-3 bg-slate-100 dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-700 text-xs">
                    <div>
                        <p class="text-slate-500">Nivel</p>
                        <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">{{ $pokemon->level }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500">Altura</p>
                        <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">{{ $details['height'] }} m</p>
                    </div>
                    <div>
                        <p class="text-slate-500">Peso</p>
                        <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">{{ $details['weight'] }} kg</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('inventory.nickname', $pokemon) }}" method="POST" class="space-y-3 text-left bg-slate-50 dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-700">
                @csrf
                @method('PATCH')
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Asignar un Mote:</label>
                <div class="flex gap-2">
                    <input type="text" name="nickname" value="{{ $pokemon->nickname }}" placeholder="Ej: Rayito" class="flex-1 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white rounded-md text-sm focus:border-poke-yellow focus:ring-poke-yellow">
                    <button type="submit" class="text-xs bg-poke-yellow text-slate-900 font-bold px-4 py-2 rounded-md hover:bg-yellow-300 transition">
                        Guardar
                    </button>
                </div>
            </form>

            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <a href="{{ route('wild.index') }}" class="flex-1 text-xs bg-poke-red hover:bg-poke-darkred text-white py-3 rounded-xl font-bold shadow text-center transition">
                    🌲 Ir a Capturar Más
                </a>
                <a href="{{ route('inventory.index') }}" class="flex-1 text-xs bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200 py-3 rounded-xl font-bold shadow text-center transition">
                    🎒 Ver Inventario
                </a>
            </div>
        </div>
    </div>
</x-app-layout>