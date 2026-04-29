<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('servicios')->insert([
            ['nombre' => 'Cambio de Pantalla', 'descripcion' => null],
            ['nombre' => 'Cambio de Batería', 'descripcion' => null],
            ['nombre' => 'Reparación de Placa', 'descripcion' => null],
            ['nombre' => 'Mantenimiento general', 'descripcion' => null],
            ['nombre' => 'Limpieza Interna', 'descripcion' => null],
        ]);
    }
}