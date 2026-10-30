<?php

use App\Models\CapturedPokemon;
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

test('un entrenador puede capturar un pokemon con masterball asegurada (100%)', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('wild.catch'), [
        'pokeapi_id' => 25,
        'name' => 'Pikachu',
        'types' => 'Electric',
        'sprite_url' => 'https://example.com/pikachu.png',
        'pokeball_type' => 'masterball',
        'nickname' => 'Chispas',
    ]);

    $pokemon = CapturedPokemon::firstWhere('name', 'Pikachu');
    $response->assertRedirect(route('inventory.success', $pokemon));
    $this->assertDatabaseHas('captured_pokemons', [
        'user_id' => $user->id,
        'name' => 'Pikachu',
        'nickname' => 'Chispas',
        'pokeball_type' => 'masterball',
    ]);
});

test('no se pueden marcar mas de 6 pokemons como favoritos', function () {
    $user = User::factory()->create();

    CapturedPokemon::factory()->count(6)->create([
        'user_id' => $user->id,
        'is_favorite' => true,
    ]);

    $seventh = CapturedPokemon::factory()->create([
        'user_id' => $user->id,
        'is_favorite' => false,
    ]);

    $response = $this->actingAs($user)->patch(route('inventory.favorite', $seventh));

    $response->assertSessionHas('error', 'Tu Equipo Activo ya tiene el máximo de 6 Pokémon favoritos.');
    expect($seventh->fresh()->is_favorite)->toBeFalse();
});

test('un entrenador puede liberar un pokemon de su inventario', function () {
    $user = User::factory()->create();
    $pokemon = CapturedPokemon::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->delete(route('inventory.release', $pokemon));

    $response->assertStatus(302);
    $this->assertDatabaseMissing('captured_pokemons', ['id' => $pokemon->id]);
});
