<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServicioTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_crear_servicio()
    {
        $user = Usuario::factory()->create();

        $response = $this->actingAs($user)->post('/servicios', [
            'descripcion' => 'Pantalla dañada',
            'tipo' => 'Reparación'
        ]);

        $response->assertStatus(302);
    }
}
