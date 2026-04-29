<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServicioTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_crear_servicio()
    {
        // Ejecutar migraciones
        $this->artisan('migrate');

        // Crear usuario
        $user = User::factory()->create();

        // Simular petición
        $response = $this->actingAs($user)->post('/servicios', [
            'descripcion' => 'Pantalla dañada',
            'tipo' => 'Reparación'
        ]);

        $response->assertStatus(302);
    }
}