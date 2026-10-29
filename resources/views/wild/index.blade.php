<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zona Salvaje - Buscar y Capturar') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 font-medium rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Buscador -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <form action="{{ route('wild.index') }}" method="GET" class="flex gap-4">
                <input type="text" name="search" value="{{ $search }}" placeholder="Escribe un nombre o ID de Pokémon..." class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-bold">Buscar</button>
                <a href="{{ route('wild.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 font-bold flex items-center">Aleatorio</a>
            </form>
        </div>

        @if ($pokemon)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden grid md:grid-cols-2 p-6 gap-6">
                <div class="flex flex-col items-center justify-center bg-gray-50 rounded-lg p-4">
                    <img src="{{ $pokemon['sprite'] }}" alt="{{ $pokemon['name'] }}" class="w-56 h-56 object-contain animate-bounce">
                    <h3 class="text-3xl font-extrabold text-gray-800 mt-2">{{ $pokemon['name'] }} #{{ $pokemon['id'] }}</h3>
                    <span class="mt-1 inline-block bg-indigo-100 text-indigo-800 text-sm font-semibold px-3 py-1 rounded-full">{{ $pokemon['types'] }}</span>
                </div>

                <div>
                    <h4 class="text-xl font-bold text-gray-700 mb-4">Lanzar Pokéball</h4>
                    <form action="{{ route('wild.catch') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="pokeapi_id" value="{{ $pokemon['id'] }}">
                        <input type="hidden" name="name" value="{{ $pokemon['name'] }}">
                        <input type="hidden" name="types" value="{{ $pokemon['types'] }}">
                        <input type="hidden" name="sprite_url" value="{{ $pokemon['sprite'] }}">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mote personalizado (Opcional):</label>
                            <input type="text" name="nickname" placeholder="Ej: Rayito" class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona Pokéball:</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="border rounded-md p-3 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="pokeball_type" value="pokeball" checked>
                                    <span class="font-medium text-gray-800">Pokéball (45%)</span>
                                </label>
                                <label class="border rounded-md p-3 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="pokeball_type" value="superball">
                                    <span class="font-medium text-blue-600">Superball (70%)</span>
                                </label>
                                <label class="border rounded-md p-3 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="pokeball_type" value="ultraball">
                                    <span class="font-medium text-yellow-600">Ultraball (88%)</span>
                                </label>
                                <label class="border rounded-md p-3 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="pokeball_type" value="masterball">
                                    <span class="font-medium text-purple-600">Masterball (100%)</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-black text-lg rounded-md shadow transition">
                            ¡LANZAR POKÉBALL!
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                No se ha encontrado ningún Pokémon con ese nombre o ID.
            </div>
        @endif
    </div>
</x-app-layout>