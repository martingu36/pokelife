<?php

namespace App\Http\Controllers;

use App\Models\CapturedPokemon;
use App\Services\PokeApiService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->capturedPokemons()
            ->orderBy('is_favorite', 'desc')
            ->orderBy('created_at', 'desc');

        // Filtro 1: Búsqueda por Nombre o Mote
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        // Filtro 2: Filtro por Tipo
        if ($request->filled('type')) {
            $type = trim($request->input('type'));
            $query->where('types', 'like', "%{$type}%");
        }

        // Filtro 3: Solo Favoritos
        if ($request->boolean('favorites')) {
            $query->where('is_favorite', true);
        }

        $pokemons = $query->get();

        // Obtener la lista dinámica de tipos capturados por el usuario para el desplegable
        $availableTypes = auth()->user()->capturedPokemons()
            ->pluck('types')
            ->flatMap(fn ($t) => array_map('trim', explode('/', strtolower($t))))
            ->unique()
            ->sort()
            ->values();

        $favoriteCount = auth()->user()->capturedPokemons()->where('is_favorite', true)->count();

        return view('inventory.index', [
            'pokemons' => $pokemons,
            'favoriteCount' => $favoriteCount,
            'availableTypes' => $availableTypes,
            'filters' => $request->only(['search', 'type', 'favorites']),
        ]);
    }

    public function captured(CapturedPokemon $pokemon, PokeApiService $pokeApi)
    {
        if ($pokemon->user_id !== auth()->id()) {
            abort(403);
        }

        $details = $pokeApi->getPokemon($pokemon->pokeapi_id);

        return view('inventory.captured', compact('pokemon', 'details'));
    }

    public function updateNickname(Request $request, CapturedPokemon $pokemon)
    {
        $this->authorizeOwner($pokemon);

        $validated = $request->validate([
            'nickname' => 'nullable|string|max:30',
        ]);

        $pokemon->update(['nickname' => $validated['nickname']]);

        return back()->with('success', 'Mote actualizado correctamente.');
    }

    public function toggleFavorite(CapturedPokemon $pokemon)
    {
        $this->authorizeOwner($pokemon);

        if (! $pokemon->is_favorite) {
            $currentFavorites = auth()->user()->capturedPokemons()->where('is_favorite', true)->count();
            if ($currentFavorites >= 6) {
                return back()->with('error', 'Tu Equipo Activo ya tiene el máximo de 6 Pokémon favoritos.');
            }
        }

        $pokemon->update(['is_favorite' => ! $pokemon->is_favorite]);

        return back()->with('success', $pokemon->is_favorite ? 'Añadido a tu Equipo Activo.' : 'Quitado de tu Equipo Activo.');
    }

    public function release(CapturedPokemon $pokemon)
    {
        $this->authorizeOwner($pokemon);

        $name = $pokemon->nickname ?: $pokemon->name;
        $pokemon->delete();

        return back()->with('success', "Has liberado a {$name} en la naturaleza.");
    }

    private function authorizeOwner(CapturedPokemon $pokemon): void
    {
        if ($pokemon->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
