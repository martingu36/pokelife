<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Carnet de Entrenador -->
        <div class="bg-gradient-to-r from-poke-red to-red-700 text-white rounded-2xl p-6 shadow-2xl border-4 border-slate-950 relative overflow-hidden">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-6 relative z-10">
                <div class="flex items-center gap-4">
                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/ultra-ball.png" class="w-16 h-16 drop-shadow">
                    <div>
                        <span class="font-pixel text-[10px] bg-slate-950 text-poke-yellow px-3 py-1 rounded-full uppercase font-bold">{{ $rank }}</span>
                        <h1 class="font-pixel text-xl sm:text-2xl mt-2">{{ $user->name }}</h1>
                        <p class="text-xs text-red-100 mt-1">Miembro desde: {{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="bg-slate-950/80 p-4 rounded-xl text-center border border-red-400/40 min-w-[140px]">
                    <p class="text-slate-400 text-xs uppercase font-bold">Total Capturas</p>
                    <p class="font-pixel text-2xl text-poke-yellow mt-1">{{ $totalCaptured }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Equipo Favorito (6 Slot Maximum) -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xl space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        ⭐ Equipo Activo (Favoritos)
                    </h3>
                    <span class="text-xs font-bold text-slate-500">{{ $favorites->count() }} / 6</span>
                </div>

                @if($favorites->isEmpty())
                    <p class="text-xs text-slate-500 text-center py-6">No has seleccionado ningún Pokémon favorito aún en tu inventario.</p>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($favorites as $fav)
                            <div class="bg-slate-50 dark:bg-slate-900 p-3 rounded-xl border border-slate-200 dark:border-slate-700 flex flex-col items-center text-center">
                                <img src="{{ $fav->sprite_url }}" class="w-16 h-16 object-contain">
                                <p class="font-pixel text-[10px] text-slate-800 dark:text-poke-yellow mt-1">{{ $fav->nickname ?: $fav->name }}</p>
                                <span class="text-[10px] text-slate-500">Niv. {{ $fav->level }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Últimas Capturas y Expedición -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xl space-y-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-sm text-slate-800 dark:text-slate-100 mb-4">
                        🕒 Capturas Recientes
                    </h3>
                    @if($recentCaptures->isEmpty())
                        <p class="text-xs text-slate-500">No hay registros de capturas recientes.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($recentCaptures as $rec)
                                <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-900 p-2.5 rounded-lg border border-slate-200 dark:border-slate-700">
                                    <img src="{{ $rec->sprite_url }}" class="w-10 h-10 object-contain">
                                    <div class="flex-1">
                                        <p class="font-bold text-xs text-slate-800 dark:text-slate-200">{{ $rec->nickname ?: $rec->name }}</p>
                                        <p class="text-[10px] text-slate-500">{{ $rec->captured_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <a href="{{ route('wild.index') }}" class="block w-full text-center font-bold text-xs bg-poke-red hover:bg-poke-darkred text-white py-3.5 rounded-xl shadow-lg transition">
                    🌲 IR A LA ZONA SALVAJE
                </a>
            </div>
        </div>
    </div>
</x-app-layout>