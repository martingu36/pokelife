<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-slate-800 border-2 border-poke-yellow rounded-2xl shadow-2xl overflow-hidden p-6 text-center space-y-6 relative">
            <div class="inline-block bg-yellow-400 text-slate-900 font-pixel text-xs px-4 py-2 rounded-full uppercase font-bold tracking-wider animate-pulse">
                🎉 ¡POKÉMON CAPTURADO!
            </div>

            <!-- Sprite y Muestra Principal -->
            <div class="relative bg-slate-900/80 rounded-xl p-6 border border-slate-700 flex flex-col items-center">
                <img src="{{ $pokemon->sprite_url }}" alt="{{ $pokemon->name }}" class="w-48 h-48 object-contain drop-shadow-2xl">
                <h2 class="font-pixel text-2xl text-poke-yellow mt-2">{{ $pokemon->name }}</h2>
                <span class="text-xs bg-poke-red text-white font-bold px-3 py-1 rounded-full mt-1">{{ $pokemon->types }}</span>
            </div>

            <!-- Estadísticas Básicas de PokeAPI -->
            @if($details)
                <div class="grid grid-cols-3 gap-3 bg-slate-900 p-4 rounded-xl border border-slate-700 text-xs">
                    <div>
                        <p class="text-slate-400">Nivel</p>
                        <p class="font-bold text-slate-100 text-sm">{{ $pokemon->level }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Altura</p>
                        <p class="font-bold text-slate-100 text-sm">{{ $details['height'] }} m</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Peso</p>
                        <p class="font-bold text-slate-100 text-sm">{{ $details['weight'] }} kg</p>
                    </div>
                </div>
            @endif

            <!-- Formulario de Mote Personalizado -->
            <form action="{{ route('inventory.nickname', $pokemon) }}" method="POST" class="space-y-4 text-left bg-slate-900 p-4 rounded-xl border border-slate-700">
                @csrf
                @method('PATCH')
                <label class="block font-pixel text-xs text-slate-300">Asignar Mote al Pokémon:</label>
                <div class="flex gap-2">
                    <input type="text" name="nickname" value="{{ $pokemon->nickname }}" placeholder="Ej: Rayito" class="flex-1 bg-slate-800 border-slate-700 text-white rounded-md text-sm focus:border-poke-yellow focus:ring-poke-yellow">
                    <button type="submit" class="font-pixel text-xs bg-poke-yellow text-slate-900 font-bold px-4 py-2 rounded-md hover:bg-yellow-300 transition">
                        Guardar
                    </button>
                </div>
            </form>

            <!-- Acciones -->
            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <a href="{{ route('wild.index') }}" class="flex-1 font-pixel text-xs bg-poke-red hover:bg-poke-darkred text-white py-3 rounded-xl font-bold shadow text-center transition">
                    🌲 CORTAR E IR POR OTRO
                </a>
                <a href="{{ route('inventory.index') }}" class="flex-1 font-pixel text-xs bg-slate-700 hover:bg-slate-600 text-slate-200 py-3 rounded-xl font-bold shadow text-center transition">
                    🎒 VER EN INVENTARIO
                </a>
            </div>
        </div>
    </div>
</x-app-layout>