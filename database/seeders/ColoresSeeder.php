<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColoresSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('colores')->insert([
            ['nombre' => 'Negro'],
            ['nombre' => 'Blanco'],
            ['nombre' => 'Gris'],
            ['nombre' => 'Azul'],
            ['nombre' => 'Rojo'],
            ['nombre' => 'Verde'],
            ['nombre' => 'Amarillo'],
            ['nombre' => 'Dorado'],
            ['nombre' => 'Plateado'],
        ]);
    }
}