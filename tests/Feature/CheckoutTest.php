<?php
use App\Models\Producto;
use App\Models\Rol;
use App\Models\Usuario;

test('checkout page requiere autenticacion', function () {
    $response = $this->get(route('checkout.index'));
    $response->assertRedirect(route('login'));
});

test('usuario autenticado puede ver checkout', function () {
    $rol = Rol::factory()->create(['nombre' => 'cliente']);
    $user = Usuario::factory()->create(['rol_id' => $rol->id]);

    $producto = Producto::factory()->create(['stock' => 10, 'estado' => 1]);
    session()->put('carrito', [$producto->id => [
        'id' => $producto->id,
        'nombre' => $producto->nombre,
        'precio' => $producto->precio,
        'imagen' => '',
        'cantidad' => 1,
    ]]);

    $response = $this->actingAs($user)->get(route('checkout.index'));
    $response->assertStatus(200);
});
