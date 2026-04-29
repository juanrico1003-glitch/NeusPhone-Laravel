<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['nombre' => 'Celulares'],
            ['nombre' => 'PC'],
            ['nombre' => 'Audífonos'],
            ['nombre' => 'Radios'],
            ['nombre' => 'Memorias'],
        ]);
    }
}