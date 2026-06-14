<?php

use App\Models\Usuario;

test('reset password link screen can be rendered', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
});

test('reset password can be requested for existing email', function () {
    $user = Usuario::factory()->create();

    $response = $this->post('/forgot-password', ['correo' => $user->correo]);

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('status');
});
