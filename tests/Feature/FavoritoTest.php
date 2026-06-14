<?php
use App\Models\Rol;
use App\Models\Usuario;

test('favoritos requiere autenticacion', function () {
    $response = $this->get(route('favoritos.index'));
    $response->assertRedirect(route('login'));
});

test('usuario puede ver favoritos', function () {
    $rol = Rol::factory()->create(['nombre' => 'cliente']);
    $user = Usuario::factory()->create(['rol_id' => $rol->id]);
    
    $response = $this->actingAs($user)->get(route('favoritos.index'));
    $response->assertStatus(200);
});
