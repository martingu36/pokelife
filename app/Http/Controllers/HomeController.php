<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $pokemons = $user->capturedPokemons();
        $totalCaptured = $pokemons->count();
        $favorites = $user->capturedPokemons()->where('is_favorite', true)->get();
        $recentCaptures = $user->capturedPokemons()->orderBy('created_at', 'desc')->take(3)->get();

        // Determinar Rango del Entrenador según capturas
        $rank = match (true) {
            $totalCaptured >= 20 => 'Maestro Pokémon',
            $totalCaptured >= 10 => 'Entrenador Experto',
            $totalCaptured >= 5 => 'Promesa Pokémon',
            default => 'Novato de Pueblo Paleta',
        };

        return view('home', compact('user', 'totalCaptured', 'favorites', 'recentCaptures', 'rank'));
    }
}
