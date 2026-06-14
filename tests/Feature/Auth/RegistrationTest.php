<?php

use App\Models\Rol;
use Illuminate\Support\Facades\Artisan;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    Rol::create(['nombre' => 'cliente']);

    $response = $this->post('/register', [
        'nombres' => 'Test',
        'apellidos' => 'User',
        'cedula' => '123456789',
        'correo' => 'test@example.com',
        'fecha_nacimiento' => '1990-01-01',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(302);
    $this->assertAuthenticated();
});
