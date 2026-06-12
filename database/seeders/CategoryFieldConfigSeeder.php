<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryFieldConfigSeeder extends Seeder
{
    public function run(): void
    {
        $configs = [
            'Celulares' => ['color', 'ram', 'almacenamiento'],
            'Laptop' => ['ram', 'almacenamiento'],
            'Tablets' => ['color', 'ram', 'almacenamiento'],
            'Portátiles' => ['color', 'ram', 'almacenamiento'],
            'PC Escritorio' => ['ram', 'almacenamiento'],
            'Monitores' => ['color'],
            'Televisores' => ['color'],
            'Smartwatches' => ['color', 'ram', 'almacenamiento'],
            'Audífonos' => ['color'],
            'Parlantes y Equipos de Sonido' => ['color'],
            'Radios' => ['color'],
            'Memorias RAM' => ['ram'],
            'Discos SSD' => ['almacenamiento'],
            'Discos HDD' => ['almacenamiento'],
            'Tarjetas Gráficas' => ['ram'],
            'Teclados' => ['color'],
            'Ratones' => ['color'],
            'Cables y Accesorios' => ['color'],
        ];

        foreach ($configs as $categoriaNombre => $campos) {
            $catId = DB::table('categorias')->where('nombre', $categoriaNombre)->value('id');
            if (!$catId) continue;

            foreach ($campos as $campo) {
                DB::table('category_field_configs')->insertOrIgnore([
                    'categoria_id' => $catId,
                    'campo' => $campo,
                ]);
            }
        }
    }
}
