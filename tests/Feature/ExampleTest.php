<?php

use App\Models\User;

test('la pagina principal de bienvenida responde correctamente a visitantes', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('¡TU AVENTURA POKÉMON EMPIEZA AQUÍ!');
});

test('los usuarios autenticados son redirigidos de la bienvenida al centro de entrenador', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/');

    $response->assertRedirect(route('home'));
});
