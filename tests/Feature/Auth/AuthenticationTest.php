<?php

use App\Models\Usuario;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = Usuario::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'correo' => $user->correo,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect();
});

test('users can not authenticate with invalid password', function () {
    $user = Usuario::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $this->post('/login', [
        'correo' => $user->correo,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = Usuario::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
