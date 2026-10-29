<?php

namespace App\Http\Controllers;

use App\Models\CapturedPokemon;
use App\Services\PokeApiService;
use Illuminate\Http\Request;

class WildPokemonController extends Controller
{
    public function index(Request $request, PokeApiService $pokeApi)
    {
        $query = $request->input('search');
        $pokemonId = $query ? strtolower(trim($query)) : $pokeApi->getRandomPokemonId();

        $pokemon = $pokeApi->getPokemon($pokemonId);

        return view('wild.index', [
            'pokemon' => $pokemon,
            'search' => $query,
        ]);
    }

    public function catch(Request $request, PokeApiService $pokeApi)
    {
        $validated = $request->validate([
            'pokeapi_id' => 'required|integer',
            'name' => 'required|string',
            'types' => 'required|string',
            'sprite_url' => 'required|url',
            'pokeball_type' => 'required|in:pokeball,superball,ultraball,masterball',
            'nickname' => 'nullable|string|max:30',
        ]);

        $success = $pokeApi->attemptCatch($validated['pokeball_type']);

        if (! $success) {
            return back()->with('error', "¡El {$validated['name']} salvaje ha escapado de la {$validated['pokeball_type']}!");
        }

        CapturedPokemon::create([
            'user_id' => auth()->id(),
            'pokeapi_id' => $validated['pokeapi_id'],
            'name' => $validated['name'],
            'nickname' => $validated['nickname'],
            'types' => $validated['types'],
            'sprite_url' => $validated['sprite_url'],
            'level' => rand(1, 100),
            'pokeball_type' => $validated['pokeball_type'],
            'captured_at' => now(),
        ]);

        return redirect()->route('inventory.index')
            ->with('success', "¡Felicidades! Capturaste a {$validated['name']}.");
    }
}
