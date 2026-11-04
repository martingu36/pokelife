<?php

namespace App\Http\Controllers;

use App\Models\CapturedPokemon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = CapturedPokemon::where('user_id', auth()->id());

        // Búsqueda por nombre o mote
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        // Filtrado por tipo elemental usando sintaxis JSON nativa
        if ($request->filled('type')) {
            $selectedType = strtolower(trim($request->input('type')));
            $query->whereJsonContains('types', $selectedType);
        }

        $pokemons = $query->orderBy('is_favorite', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Obtener todos los tipos únicos presentes en la colección del usuario para los selectores
        $availableTypes = CapturedPokemon::where('user_id', auth()->id())
            ->get()
            ->pluck('types')
            ->flatten()
            ->filter()
            ->map(fn ($t) => strtolower((string) $t))
            ->unique()
            ->values();

        return view('inventory.index', compact('pokemons', 'availableTypes'));
    }

    public function updateNickname(Request $request, $id)
    {
        $request->validate([
            'nickname' => 'nullable|string|max:20',
        ]);

        $pokemon = CapturedPokemon::where('user_id', auth()->id())->findOrFail($id);
        $pokemon->update([
            'nickname' => $request->input('nickname'),
        ]);

        return redirect()->back()->with('success', 'Apodo actualizado correctamente.');
    }

    public function toggleFavorite($id)
    {
        $pokemon = CapturedPokemon::where('user_id', auth()->id())->findOrFail($id);
        $pokemon->update([
            'is_favorite' => ! $pokemon->is_favorite,
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $pokemon = CapturedPokemon::where('user_id', auth()->id())->findOrFail($id);
        $pokemon->delete();

        return redirect()->route('inventory.index')->with('success', 'Pokémon liberado con éxito.');
    }
}
