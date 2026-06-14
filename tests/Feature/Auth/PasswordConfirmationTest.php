<?php

use App\Models\Usuario;

test('confirm password screen can be rendered', function () {
    $user = Usuario::factory()->create();

    $response = $this->actingAs($user)->get('/confirm-password');

    $response->assertStatus(200);
});
