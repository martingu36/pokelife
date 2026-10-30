<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-pixel text-sm text-slate-100">
                🎒 MI INVENTARIO
            </h2>
            <span class="font-pixel text-xs bg-yellow-400 text-slate-900 px-3 py-1 rounded-full font-bold">
                EQUIPO FAVORITO: {{ $favoriteCount }} / 6
            </span>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        @if (session('success'))
            <div class="p-4 bg-green-900/80 border-l-4 border-green-500 text-green-200 font-medium rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($pokemons->isEmpty())
            <div class="bg-slate-800 p-8 rounded-2xl border border-slate-700 text-center space-y-4">
                <p class="text-slate-400 text-base">Aún no has capturado ningún Pokémon.</p>
                <a href="{{ route('wild.index') }}" class="inline-block font-pixel text-xs bg-poke-red text-white font-bold px-6 py-3 rounded-xl hover:bg-poke-darkred transition shadow-lg">Ir a la Zona Salvaje</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pokemons as $p)
                    <div class="bg-slate-800 rounded-2xl p-5 border-2 {{ $p->is_favorite ? 'border-yellow-400 bg-slate-800/90' : 'border-slate-700' }} relative shadow-xl flex flex-col justify-between">
                        @if($p->is_favorite)
                            <span class="absolute top-3 right-3 text-xl" title="Equipo Activo">⭐</span>
                        @endif

                        <div class="flex items-center gap-4">
                            <img src="{{ $p->sprite_url }}" alt="{{ $p->name }}" class="w-20 h-20 object-contain drop-shadow">
                            <div>
                                <h3 class="font-pixel text-sm text-poke-yellow">{{ $p->nickname ?: $p->name }}</h3>
                                @if($p->nickname)
                                    <p class="text-xs text-slate-400">Especie: {{ $p->name }}</p>
                                @endif
                                <p class="text-xs font-semibold text-slate-300 mt-1">Nivel {{ $p->level }}</p>
                                <span class="inline-block bg-poke-red text-white text-[10px] font-bold px-2 py-0.5 rounded mt-1">{{ $p->types }}</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-700 space-y-3">
                            <form action="{{ route('inventory.nickname', $p) }}" method="POST" class="flex gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="nickname" value="{{ $p->nickname }}" placeholder="Mote..." class="flex-1 bg-slate-900 border-slate-700 text-white text-xs rounded-md">
                                <button type="submit" class="font-pixel text-[10px] bg-slate-700 text-slate-200 px-2 py-1 rounded hover:bg-slate-600">OK</button>
                            </form>

                            <div class="flex justify-between items-center">
                                <form action="{{ route('inventory.favorite', $p) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="font-pixel text-[10px] px-3 py-1.5 rounded-md font-bold {{ $p->is_favorite ? 'bg-yellow-400 text-slate-900' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' }}">
                                        {{ $p->is_favorite ? '★ EN EQUIPO' : '☆ FAVORITO' }}
                                    </button>
                                </form>

                                <form action="{{ route('inventory.release', $p) }}" method="POST" onsubmit="return confirm('¿Liberar a este Pokémon?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-pixel text-[10px] bg-red-950 text-red-400 hover:bg-red-900 px-3 py-1.5 rounded-md font-bold border border-red-800">
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