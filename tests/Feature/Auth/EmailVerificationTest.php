<?php

use App\Models\Usuario;

test('unverified user can render email verification notice', function () {
    $user = Usuario::factory()->create(['estado' => 1]);

    $response = $this->actingAs($user)->get('/verify-email');

    $response->assertStatus(200);
});
