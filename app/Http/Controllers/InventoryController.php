<?php

namespace App\Http\Controllers;

use App\Models\CapturedPokemon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $pokemons = auth()->user()->capturedPokemons()
            ->orderBy('is_favorite', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $favoriteCount = $pokemons->where('is_favorite', true)->count();

        return view('inventory.index', compact('pokemons', 'favoriteCount'));
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
