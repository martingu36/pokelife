<?php

use App\Models\CapturedPokemon;
use App\Models\User;

function makeCapturedPokemon(User $user, array $overrides = []): CapturedPokemon
{
    return CapturedPokemon::create(array_merge([
        'user_id' => $user->id,
        'pokeapi_id' => 25,
        'name' => 'Pikachu',
        'nickname' => null,
        'level' => 15,
        'category' => 'Pokémon Ratón',
        'gender' => 'male',
        'height' => 0.4,
        'weight' => 6.0,
        'sprite_url' => 'https://example.com/pikachu.png',
        'types' => ['electric'],
        'weaknesses' => ['ground'],
        'hp' => 35,
        'attack' => 55,
        'defense' => 40,
        'special_attack' => 50,
        'special_defense' => 50,
        'speed' => 90,
        'pokeball_type' => 'pokeball',
        'is_favorite' => false,
        'is_shiny' => false,
    ], $overrides));
}

test('permite actualizar el apodo de un pokemon y valida la longitud maxima', function () {
    $trainer = User::factory()->create();
    $pokemon = makeCapturedPokemon($trainer);

    $this->actingAs($trainer)
        ->patch(route('inventory.nickname', $pokemon), ['nickname' => 'Chispitas'])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($pokemon->fresh()->nickname)->toBe('Chispitas');

    $this->actingAs($trainer)
        ->patch(route('inventory.nickname', $pokemon), ['nickname' => str_repeat('a', 21)])
        ->assertSessionHasErrors('nickname');
});

test('permite marcar y desmarcar un pokemon como favorito', function () {
    $trainer = User::factory()->create();
    $pokemon = makeCapturedPokemon($trainer, ['is_favorite' => false]);

    $this->actingAs($trainer)
        ->patch(route('inventory.favorite', $pokemon))
        ->assertRedirect();

    expect($pokemon->fresh()->is_favorite)->toBeTrue();
});

test('permite liberar un pokemon del inventario', function () {
    $trainer = User::factory()->create();
    $pokemon = makeCapturedPokemon($trainer);

    $this->actingAs($trainer)
        ->delete(route('inventory.destroy', $pokemon))
        ->assertRedirect(route('inventory.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('captured_pokemons', ['id' => $pokemon->id]);
});

test('impide modificar o liberar pokemon de otro entrenador', function () {
    $trainer = User::factory()->create();
    $rival = User::factory()->create();
    $rivalPokemon = makeCapturedPokemon($rival);

    $this->actingAs($trainer)
        ->patch(route('inventory.nickname', $rivalPokemon), ['nickname' => 'Robado'])
        ->assertNotFound();

    $this->actingAs($trainer)
        ->patch(route('inventory.favorite', $rivalPokemon))
        ->assertNotFound();

    $this->actingAs($trainer)
        ->delete(route('inventory.destroy', $rivalPokemon))
        ->assertNotFound();
});
