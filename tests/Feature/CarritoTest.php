<?php
use App\Models\Producto;
use App\Models\Usuario;

test('visitante puede ver carrito vacio', function () {
    $response = $this->get(route('carrito.index'));
    $response->assertStatus(200);
});

test('producto se puede agregar al carrito en sesion', function () {
    $producto = Producto::factory()->create(['stock' => 10, 'estado' => 1]);
    $response = $this->post(route('carrito.agregar', $producto->id));
    $response->assertStatus(302);
});
