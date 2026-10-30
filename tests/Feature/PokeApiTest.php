<?php

use App\Models\User;
use Illuminate\Support\Facades\Http;

test('se muestra la vista de la zona salvaje simulando la respuesta de PokeAPI', function () {
    Http::fake([
        'https://pokeapi.co/api/v2/pokemon/*' => Http::response([
            'id' => 25,
            'name' => 'pikachu',
            'sprites' => [
                'other' => ['official-artwork' => ['front_default' => 'https://example.com/pikachu.png']],
                'front_default' => 'https://example.com/pikachu.png',
            ],
            'types' => [
                ['type' => ['name' => 'electric']],
            ],
            'height' => 4,
            'weight' => 60,
            'stats' => [],
        ], 200),
    ]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('wild.index', ['search' => 'pikachu']));

    $response->assertStatus(200);
    $response->assertSee('Pikachu');
});

test('un entrenador puede acceder a su centro de entrenador home', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('home'));

    $response->assertStatus(200);
    $response->assertSee('Total Capturas');
});
