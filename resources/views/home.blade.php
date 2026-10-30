<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Carnet de Entrenador (Degradado Unidireccional Adaptativo) -->
        <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-900 dark:from-slate-900 dark:via-slate-900 dark:to-red-950/80 text-white rounded-2xl p-6 border border-red-500/30 dark:border-red-900/40 shadow-md relative overflow-hidden transition-colors duration-200">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-6 relative z-10">
                <div class="flex items-center gap-4">
                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png" class="w-12 h-12 drop-shadow-md">
                    <div>
                        <span class="font-pixel text-[10px] bg-red-950/40 dark:bg-poke-red text-white px-3 py-1 rounded-full uppercase font-bold tracking-wider backdrop-blur-sm border border-white/10 dark:border-transparent">{{ $rank }}</span>
                        <h1 class="font-pixel text-xl sm:text-2xl mt-2 text-poke-yellow drop-shadow">{{ $user->name }}</h1>
                        <p class="text-xs text-red-100 dark:text-slate-400 mt-1">Miembro desde: {{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="bg-red-950/30 dark:bg-slate-950/80 backdrop-blur-sm p-4 rounded-xl text-center border border-red-400/20 dark:border-red-900/30 min-w-[140px]">
                    <p class="text-red-100 dark:text-slate-300 text-xs uppercase font-bold tracking-wider">Total Capturas</p>
                    <p class="font-pixel text-2xl text-poke-yellow mt-1 drop-shadow">{{ $totalCaptured }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Equipo Favorito -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-slate-100 uppercase tracking-wide">
                        Equipo Activo (Favoritos)
                    </h3>
                    <span class="text-xs font-bold text-slate-500">{{ $favorites->count() }} / 6</span>
                </div>

                @if($favorites->isEmpty())
                    <p class="text-xs text-slate-500 dark:text-slate-400 text-center py-8">No has seleccionado ningún Pokémon favorito aún en tu inventario.</p>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($favorites as $fav)
                            <div class="bg-slate-50 dark:bg-slate-950 p-4 rounded-xl border border-slate-200 dark:border-slate-800/80 flex flex-col items-center text-center">
                                <img src="{{ $fav->sprite_url }}" class="w-16 h-16 object-contain">
                                <p class="font-pixel text-[10px] text-slate-900 dark:text-poke-yellow mt-2">{{ $fav->nickname ?: $fav->name }}</p>
                                <span class="text-[10px] text-slate-500 mt-0.5">Nivel {{ $fav->level }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Últimas Capturas y Acción -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-sm text-slate-900 dark:text-slate-100 uppercase tracking-wide mb-4">
                        Capturas Recientes
                    </h3>
                    @if($recentCaptures->isEmpty())
                        <p class="text-xs text-slate-500 dark:text-slate-400">No hay registros de capturas recientes.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($recentCaptures as $rec)
                                <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-950 p-3 rounded-xl border border-slate-200 dark:border-slate-800/80">
                                    <img src="{{ $rec->sprite_url }}" class="w-10 h-10 object-contain">
                                    <div class="flex-1">
                                        <p class="font-bold text-xs text-slate-900 dark:text-slate-200">{{ $rec->nickname ?: $rec->name }}</p>
                                        <p class="text-[10px] text-slate-500">{{ $rec->captured_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <a href="{{ route('wild.index') }}" class="block w-full text-center font-bold text-xs bg-poke-red hover:bg-poke-darkred text-white py-3.5 rounded-xl shadow transition uppercase tracking-wider">
                    Ir a la Zona Salvaje
                </a>
            </div>
        </div>
    </div>
</x-app-layout>