<?php

use App\Models\User;
use Illuminate\Support\Facades\Http;

function fakeWildPokeApi(): void
{
    Http::fake([
        'pokeapi.co/api/v2/pokemon/*' => Http::response([
            'id' => 4,
            'name' => 'charmander',
            'height' => 6,
            'weight' => 85,
            'sprites' => [
                'front_default' => 'https://example.com/charmander.png',
                'front_shiny' => 'https://example.com/charmander-shiny.png',
                'other' => [
                    'official-artwork' => [
                        'front_default' => 'https://example.com/charmander-art.png',
                        'front_shiny' => 'https://example.com/charmander-art-shiny.png',
                    ],
                ],
            ],
            'types' => [
                ['type' => ['name' => 'fire']],
            ],
            'stats' => [
                ['base_stat' => 39],
                ['base_stat' => 52],
                ['base_stat' => 43],
                ['base_stat' => 60],
                ['base_stat' => 50],
                ['base_stat' => 65],
            ],
        ], 200),
        'pokeapi.co/api/v2/pokemon-species/*' => Http::response([
            'gender_rate' => 1,
            'genera' => [
                ['language' => ['name' => 'en'], 'genus' => 'Lizard Pokémon'],
                ['language' => ['name' => 'es'], 'genus' => 'Pokémon Lagartija'],
            ],
        ], 200),
    ]);
}

test('redirige al login si un usuario no autenticado intenta entrar a la zona salvaje', function () {
    $this->get(route('wild.index'))
        ->assertRedirect(route('login'));
});

test('genera un pokemon salvaje en sesion al visitar la zona salvaje', function () {
    fakeWildPokeApi();
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('wild.index'))
        ->assertOk()
        ->assertSessionHas('wild_pokemon');

    expect(session('wild_pokemon'))
        ->toMatchArray([
            'pokeapi_id' => 4,
            'name' => 'Charmander',
            'category' => 'Pokémon Lagartija',
            'types' => ['fire'],
            'weaknesses' => ['water', 'ground', 'rock'],
        ]);
});

test('usa a Pikachu como fallback si PokeAPI falla', function () {
    Http::fake([
        '*' => Http::response([], 500),
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('wild.index'))
        ->assertOk();

    expect(session('wild_pokemon'))
        ->toMatchArray([
            'pokeapi_id' => 25,
            'name' => 'Pikachu',
            'category' => 'Pokémon Ratón',
        ]);
});

test('permite buscar un nuevo encuentro salvaje', function () {
    fakeWildPokeApi();
    $user = User::factory()->create();

    $this->actingAs($user)
        ->withSession(['wild_pokemon' => ['pokeapi_id' => 1, 'name' => 'Bulbasaur']])
        ->post(route('wild.encounter'))
        ->assertRedirect(route('wild.index'));

    expect(session('wild_pokemon.name'))->toBe('Charmander');
});

test('captura un pokemon con masterball y lo guarda en el inventario del usuario', function () {
    $user = User::factory()->create();

    $wildPokemon = [
        'pokeapi_id' => 4,
        'name' => 'Charmander',
        'level' => 12,
        'category' => 'Pokémon Lagartija',
        'gender' => 'male',
        'height' => 0.6,
        'weight' => 8.5,
        'sprite_url' => 'https://example.com/charmander-art.png',
        'types' => ['fire'],
        'weaknesses' => ['water', 'ground', 'rock'],
        'hp' => 39,
        'attack' => 52,
        'defense' => 43,
        'special_attack' => 60,
        'special_defense' => 50,
        'speed' => 65,
        'is_shiny' => false,
    ];

    $this->actingAs($user)
        ->withSession(['wild_pokemon' => $wildPokemon])
        ->post(route('wild.catch'), ['ball_type' => 'masterball'])
        ->assertRedirect(route('wild.index'))
        ->assertSessionHas('capture_success', true)
        ->assertSessionMissing('wild_pokemon');

    $this->assertDatabaseHas('captured_pokemons', [
        'user_id' => $user->id,
        'pokeapi_id' => 4,
        'name' => 'Charmander',
        'pokeball_type' => 'masterball',
    ]);
});

test('no crea ningun registro si se intenta capturar sin un pokemon salvaje en sesion', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('wild.catch'), ['ball_type' => 'masterball'])
        ->assertRedirect(route('wild.index'));

    $this->assertDatabaseCount('captured_pokemons', 0);
});
