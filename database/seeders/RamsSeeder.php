<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RamsSeeder extends Seeder
{
    public function run(): void
    {
        $rams = [
            'Celulares' => ['2 GB', '3 GB', '4 GB', '6 GB', '8 GB', '12 GB', '16 GB', '24 GB'],
            'Tablets' => ['2 GB', '3 GB', '4 GB', '6 GB', '8 GB', '12 GB', '16 GB', '24 GB', '32 GB'],
            'Portátiles' => ['4 GB', '8 GB', '12 GB', '16 GB', '24 GB', '32 GB', '48 GB', '64 GB', '96 GB', '128 GB'],
            'PC Escritorio' => ['4 GB', '8 GB', '12 GB', '16 GB', '24 GB', '32 GB', '48 GB', '64 GB', '96 GB', '128 GB', '256 GB'],
            'Smartwatches' => ['512 MB', '1 GB', '2 GB', '3 GB', '4 GB', '6 GB', '8 GB'],
            'Memorias RAM' => [
                '4 GB DDR3', '8 GB DDR3', '16 GB DDR3', '32 GB DDR3',
                '4 GB DDR4', '8 GB DDR4', '16 GB DDR4', '32 GB DDR4', '64 GB DDR4',
                '8 GB DDR5', '16 GB DDR5', '32 GB DDR5', '48 GB DDR5', '64 GB DDR5', '96 GB DDR5', '128 GB DDR5',
                '8 GB LPDDR4', '16 GB LPDDR4', '32 GB LPDDR4',
                '8 GB LPDDR5', '16 GB LPDDR5', '32 GB LPDDR5', '64 GB LPDDR5',
                '16 GB LPDDR5X', '24 GB LPDDR5X', '32 GB LPDDR5X',
            ],
            'Tarjetas Gráficas' => [
                '2 GB GDDR5', '4 GB GDDR5', '6 GB GDDR5', '8 GB GDDR5',
                '4 GB GDDR6', '6 GB GDDR6', '8 GB GDDR6', '10 GB GDDR6', '12 GB GDDR6',
                '16 GB GDDR6', '20 GB GDDR6', '24 GB GDDR6',
                '8 GB GDDR6X', '12 GB GDDR6X', '16 GB GDDR6X', '24 GB GDDR6X',
                '4 GB GDDR3', '8 GB HBM2', '16 GB HBM2', '32 GB HBM2', '64 GB HBM2',
            ],
        ];

        foreach ($rams as $categoriaNombre => $ramList) {
            $catId = DB::table('categorias')->where('nombre', $categoriaNombre)->value('id');
            if (!$catId) continue;

            foreach ($ramList as $ram) {
                DB::table('rams')->insertOrIgnore([
                    'categoria_id' => $catId,
                    'nombre' => $ram,
                ]);
            }
        }
    }
}
