<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mi Inventario de Pokémon') }}
            </h2>
            <span class="text-sm bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-bold">
                Equipo Favorito: {{ $favoriteCount }} / 6
            </span>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-medium rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 font-medium rounded">
                {{ session('error') }}
            </div>
        @endif

        @if($pokemons->isEmpty())
            <div class="bg-white p-8 rounded-lg shadow text-center">
                <p class="text-gray-500 text-lg mb-4">Aún no has capturado ningún Pokémon.</p>
                <a href="{{ route('wild.index') }}" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700">Ir a capturar</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pokemons as $p)
                    <div class="bg-white rounded-lg shadow-md p-5 border-2 {{ $p->is_favorite ? 'border-yellow-400 bg-yellow-50/20' : 'border-gray-200' }} relative">
                        @if($p->is_favorite)
                            <span class="absolute top-3 right-3 text-2xl" title="Equipo Activo">⭐</span>
                        @endif

                        <div class="flex items-center gap-4">
                            <img src="{{ $p->sprite_url }}" alt="{{ $p->name }}" class="w-24 h-24 object-contain">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $p->nickname ?: $p->name }}</h3>
                                @if($p->nickname)
                                    <p class="text-xs text-gray-500">Especie: {{ $p->name }}</p>
                                @endif
                                <p class="text-sm font-semibold text-gray-600">Nivel {{ $p->level }}</p>
                                <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded mt-1">{{ $p->types }}</span>
                                <p class="text-xs text-gray-400 mt-1">Balón: <span class="capitalize">{{ $p->pokeball_type }}</span></p>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t flex flex-col gap-2">
                            <!-- Cambiar Mote -->
                            <form action="{{ route('inventory.nickname', $p) }}" method="POST" class="flex gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="nickname" value="{{ $p->nickname }}" placeholder="Mote..." class="flex-1 text-xs rounded border-gray-300">
                                <button type="submit" class="text-xs bg-gray-700 text-white px-2 py-1 rounded hover:bg-gray-800">Guardar</button>
                            </form>

                            <div class="flex justify-between items-center mt-2">
                                <!-- Favorito -->
                                <form action="{{ route('inventory.favorite', $p) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs font-bold px-3 py-1.5 rounded {{ $p->is_favorite ? 'bg-yellow-400 text-yellow-900' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                        {{ $p->is_favorite ? '★ En Equipo' : '☆ Marcar Favorito' }}
                                    </button>
                                </form>

                                <!-- Liberar -->
                                <form action="{{ route('inventory.release', $p) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas liberar a este Pokémon?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-100 text-red-700 px-3 py-1.5 rounded hover:bg-red-200 font-bold">
                                        Liberar
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