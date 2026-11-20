<?php

use App\Models\CapturedPokemon;
use App\Models\User;

test('la ruta home redirige a la zona salvaje', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('home'));

    $response->assertRedirect(route('wild.index'));
});

test('un entrenador puede filtrar su inventario por nombre y tipo', function () {
    $user = User::factory()->create();

    CapturedPokemon::create([
        'user_id' => $user->id,
        'pokeapi_id' => 25,
        'name' => 'Pikachu',
        'nickname' => 'Chispas',
        'sprite_url' => 'https://example.com/pikachu.png',
        'types' => ['electric'],
        'weaknesses' => ['ground'],
    ]);

    CapturedPokemon::create([
        'user_id' => $user->id,
        'pokeapi_id' => 4,
        'name' => 'Charmander',
        'nickname' => 'Chispa',
        'sprite_url' => 'https://example.com/charmander.png',
        'types' => ['fire'],
        'weaknesses' => ['water', 'ground', 'rock'],
    ]);

    // Filtrar por término "Chispas"
    $response = $this->actingAs($user)->get(route('inventory.index', ['search' => 'Chispas']));
    $response->assertSee('Chispas');
    $response->assertDontSee('Charmander');

    // Filtrar por tipo "Fire"
    $responseType = $this->actingAs($user)->get(route('inventory.index', ['type' => 'fire']));
    $responseType->assertSee('Charmander');
    $responseType->assertDontSee('Pikachu');
});
