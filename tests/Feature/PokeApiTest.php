<?php

use App\Models\CapturedPokemon;
use App\Models\User;

test('un entrenador puede acceder a su centro de entrenador home', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('home'));

    $response->assertStatus(200);
    $response->assertSee('Total Capturas');
});

test('un entrenador puede filtrar su inventario por nombre y tipo', function () {
    $user = User::factory()->create();

    $pikachu = CapturedPokemon::factory()->create([
        'user_id' => $user->id,
        'name' => 'Pikachu',
        'nickname' => 'Chispas',
        'types' => 'Electric',
    ]);

    $charmander = CapturedPokemon::factory()->create([
        'user_id' => $user->id,
        'name' => 'Charmander',
        'nickname' => 'Chispa',
        'types' => 'Fire',
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
