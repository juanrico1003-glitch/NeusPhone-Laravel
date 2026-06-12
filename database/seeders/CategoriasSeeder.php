<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Celulares'],
            ['nombre' => 'Laptop'],
            ['nombre' => 'Tablets'],
            ['nombre' => 'Portátiles'],
            ['nombre' => 'PC Escritorio'],
            ['nombre' => 'Monitores'],
            ['nombre' => 'Televisores'],
            ['nombre' => 'Smartwatches'],
            ['nombre' => 'Audífonos'],
            ['nombre' => 'Parlantes y Equipos de Sonido'],
            ['nombre' => 'Radios'],
            ['nombre' => 'Memorias RAM'],
            ['nombre' => 'Discos SSD'],
            ['nombre' => 'Discos HDD'],
            ['nombre' => 'Tarjetas Gráficas'],
            ['nombre' => 'Teclados'],
            ['nombre' => 'Ratones'],
            ['nombre' => 'Cables y Accesorios'],
        ];

        foreach ($categorias as $cat) {
            if (!DB::table('categorias')->where('nombre', $cat['nombre'])->exists()) {
                DB::table('categorias')->insert($cat);
            }
        }
    }
}
