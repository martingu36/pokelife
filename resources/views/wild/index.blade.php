<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        @if (session('error'))
            <div class="p-4 bg-red-900/80 border-l-4 border-red-500 text-red-200 font-medium rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Buscador -->
        <div class="bg-slate-800 p-4 sm:p-6 rounded-xl border border-slate-700 shadow-md">
            <form action="{{ route('wild.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ $search }}" placeholder="Nombre o ID de Pokémon..." class="flex-1 bg-slate-900 border-slate-700 text-white rounded-lg text-sm focus:border-poke-yellow focus:ring-poke-yellow">
                <div class="flex gap-2">
                    <button type="submit" class="font-pixel text-xs bg-poke-yellow text-slate-900 font-bold px-4 py-3 rounded-lg hover:bg-yellow-300 transition">Buscar</button>
                    <a href="{{ route('wild.index') }}" class="font-pixel text-xs bg-slate-700 text-slate-200 font-bold px-4 py-3 rounded-lg hover:bg-slate-600 transition flex items-center">Aleatorio</a>
                </div>
            </form>
        </div>

        @if ($pokemon)
            <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-2xl overflow-hidden grid md:grid-cols-2 p-6 gap-6">
                <!-- Columna Pokémon -->
                <div class="flex flex-col items-center justify-center bg-slate-900 rounded-xl p-6 border border-slate-700/60">
                    <img src="{{ $pokemon['sprite'] }}" alt="{{ $pokemon['name'] }}" class="w-48 h-48 sm:w-56 sm:h-56 object-contain drop-shadow-xl">
                    <h3 class="font-pixel text-xl sm:text-2xl text-poke-yellow mt-2">{{ $pokemon['name'] }} #{{ $pokemon['id'] }}</h3>
                    <span class="mt-2 inline-block bg-poke-red text-white text-xs font-bold px-3 py-1 rounded-full">{{ $pokemon['types'] }}</span>

                    <!-- Stats básicas -->
                    <div class="w-full grid grid-cols-2 gap-2 mt-4 text-xs text-slate-300 bg-slate-800 p-3 rounded-lg border border-slate-700">
                        <div><span class="text-slate-500">Altura:</span> {{ $pokemon['height'] }} m</div>
                        <div><span class="text-slate-500">Peso:</span> {{ $pokemon['weight'] }} kg</div>
                    </div>
                </div>

                <!-- Columna Captura -->
                <div class="flex flex-col justify-between space-y-4">
                    <h4 class="font-pixel text-sm text-slate-200">SELECCIONAR POKÉBALL</h4>
                    <form action="{{ route('wild.catch') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="pokeapi_id" value="{{ $pokemon['id'] }}">
                        <input type="hidden" name="name" value="{{ $pokemon['name'] }}">
                        <input type="hidden" name="types" value="{{ $pokemon['types'] }}">
                        <input type="hidden" name="sprite_url" value="{{ $pokemon['sprite'] }}">

                        <div>
                            <label class="block text-xs text-slate-400 mb-1">Mote (Opcional):</label>
                            <input type="text" name="nickname" placeholder="Ej: Rayito" class="w-full bg-slate-900 border-slate-700 text-white rounded-lg text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <label class="border border-slate-700 bg-slate-900 rounded-lg p-3 flex items-center gap-2 cursor-pointer hover:border-poke-yellow transition">
                                <input type="radio" name="pokeball_type" value="pokeball" checked class="text-poke-red focus:ring-poke-red">
                                <span class="text-xs font-medium text-slate-200">Pokéball (45%)</span>
                            </label>
                            <label class="border border-slate-700 bg-slate-900 rounded-lg p-3 flex items-center gap-2 cursor-pointer hover:border-poke-yellow transition">
                                <input type="radio" name="pokeball_type" value="superball" class="text-blue-500 focus:ring-blue-500">
                                <span class="text-xs font-medium text-blue-400">Superball (70%)</span>
                            </label>
                            <label class="border border-slate-700 bg-slate-900 rounded-lg p-3 flex items-center gap-2 cursor-pointer hover:border-poke-yellow transition">
                                <input type="radio" name="pokeball_type" value="ultraball" class="text-yellow-500 focus:ring-yellow-500">
                                <span class="text-xs font-medium text-yellow-400">Ultraball (88%)</span>
                            </label>
                            <label class="border border-slate-700 bg-slate-900 rounded-lg p-3 flex items-center gap-2 cursor-pointer hover:border-poke-yellow transition">
                                <input type="radio" name="pokeball_type" value="masterball" class="text-purple-500 focus:ring-purple-500">
                                <span class="text-xs font-medium text-purple-400">Masterball (100%)</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full py-3 bg-poke-red hover:bg-poke-darkred text-white font-pixel text-xs rounded-xl shadow-lg transition">
                            ¡LANZAR POKÉBALL!
                        </button>
                    </form>

                    <a href="{{ route('wild.index') }}" class="block w-full text-center py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-200 font-pixel text-xs rounded-xl shadow transition">
                        🏃‍♂️ HUIR
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>