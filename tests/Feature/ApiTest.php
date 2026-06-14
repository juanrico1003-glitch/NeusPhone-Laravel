<?php
test('API lista productos activos', function () {
    $response = $this->getJson('/api/productos');
    $response->assertStatus(200);
    $response->assertJsonStructure(['data', 'current_page']);
});

test('API lista categorias', function () {
    $response = $this->getJson('/api/categorias');
    $response->assertStatus(200);
});
