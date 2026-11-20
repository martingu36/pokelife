<?php

use App\Services\PokeApiService;
use Illuminate\Support\Facades\Http;

test('obtiene y formatea correctamente los datos de un pokemon desde PokeAPI', function () {
    Http::fake([
        'pokeapi.co/api/v2/pokemon/pikachu' => Http::response([
            'id' => 25,
            'name' => 'pikachu',
            'height' => 4,
            'weight' => 60,
            'sprites' => [
                'front_default' => 'https://example.com/pikachu-front.png',
                'other' => [
                    'official-artwork' => [
                        'front_default' => 'https://example.com/pikachu-artwork.png',
                    ],
                ],
            ],
            'types' => [
                ['type' => ['name' => 'electric']],
            ],
            'stats' => [
                ['base_stat' => 35, 'stat' => ['name' => 'hp']],
                ['base_stat' => 55, 'stat' => ['name' => 'attack']],
            ],
        ], 200),
    ]);

    $service = new PokeApiService;
    $pokemon = $service->getPokemon('Pikachu');

    expect($pokemon)
        ->not->toBeNull()
        ->and($pokemon['id'])->toBe(25)
        ->and($pokemon['name'])->toBe('Pikachu')
        ->and($pokemon['sprite'])->toBe('https://example.com/pikachu-artwork.png')
        ->and($pokemon['types'])->toBe('Electric')
        ->and($pokemon['height'])->toBe(0.4)
        ->and($pokemon['weight'])->toEqual(6.0)
        ->and($pokemon['stats'])->toBe(['hp' => 35, 'attack' => 55]);
});

test('devuelve null cuando PokeAPI responde con error', function () {
    Http::fake([
        'pokeapi.co/api/v2/pokemon/*' => Http::response([], 404),
    ]);

    $service = new PokeApiService;

    expect($service->getPokemon('missingno'))->toBeNull();
});

test('garantiza captura con masterball y genera IDs validos de pokedex', function () {
    $service = new PokeApiService;

    expect($service->attemptCatch('masterball'))->toBeTrue()
        ->and($service->getRandomPokemonId())->toBeBetween(1, 1025);
});
