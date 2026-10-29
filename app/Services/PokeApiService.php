<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PokeApiService
{
    protected string $baseUrl = 'https://pokeapi.co/api/v2';

    public function getPokemon(string|int $identifier): ?array
    {
        $response = Http::get("{$this->baseUrl}/pokemon/".strtolower((string) $identifier));

        if ($response->failed()) {
            return null;
        }

        $data = $response->json();

        return [
            'id' => $data['id'],
            'name' => ucfirst($data['name']),
            'sprite' => $data['sprites']['other']['official-artwork']['front_default']
                        ?? $data['sprites']['front_default'],
            'types' => collect($data['types'])->map(fn ($t) => ucfirst($t['type']['name']))->implode(' / '),
            'height' => $data['height'] / 10, // en metros
            'weight' => $data['weight'] / 10, // en kg
            'stats' => collect($data['stats'])->pluck('base_stat', 'stat.name')->toArray(),
        ];
    }

    public function getRandomPokemonId(): int
    {
        return rand(1, 1025); // ID de la pokedex actual
    }

    public function attemptCatch(string $ballType): bool
    {
        $rates = [
            'pokeball' => 45,  // 45% probabilidad
            'superball' => 70, // 70% probabilidad
            'ultraball' => 88, // 88% probabilidad
            'masterball' => 100, // 100% probabilidad
        ];

        $chance = $rates[$ballType] ?? 45;

        return rand(1, 100) <= $chance;
    }
}
