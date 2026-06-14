<?php
use App\Models\Usuario;

test('pagina de login se muestra correctamente', function () {
    $response = $this->get(route('login'));
    $response->assertStatus(200);
});

test('usuario puede iniciar sesion con credenciales correctas', function () {
    $user = Usuario::factory()->create([
        'password' => bcrypt('password123'),
        'estado' => 1,
    ]);
    $response = $this->post(route('login'), [
        'correo' => $user->correo,
        'password' => 'password123',
    ]);
    $response->assertRedirect();
    $this->assertAuthenticated();
});
