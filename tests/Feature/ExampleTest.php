<?php

use App\Models\User;

test('la pagina principal redirige a la zona salvaje', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('wild.index'));
});

test('los usuarios autenticados son redirigidos de la bienvenida a la zona salvaje', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/');

    $response->assertRedirect(route('wild.index'));
});
