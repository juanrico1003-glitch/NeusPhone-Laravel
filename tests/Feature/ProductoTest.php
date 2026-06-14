<?php
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;

test('productos activos se muestran en tienda', function () {
    $categoria = Categoria::factory()->create(['nombre' => 'Test Cat']);
    Producto::factory()->count(3)->create([
        'categoria_id' => $categoria->id,
        'estado' => 1,
    ]);
    $response = $this->get(route('tienda'));
    $response->assertStatus(200);
    $response->assertSee(Producto::first()->nombre);
});

test('producto inactivo no se muestra en tienda', function () {
    $categoria = Categoria::factory()->create(['nombre' => 'Test Cat']);
    Producto::factory()->create([
        'categoria_id' => $categoria->id,
        'estado' => 0,
    ]);
    $response = $this->get(route('tienda'));
    $response->assertStatus(200);
    $response->assertDontSee(Producto::first()->nombre);
});
