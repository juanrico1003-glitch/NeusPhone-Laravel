<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlmacenamientosSeeder extends Seeder
{
    public function run(): void
    {
        $almacenamientos = [
            'Celulares' => ['16 GB', '32 GB', '64 GB', '128 GB', '256 GB', '512 GB', '1 TB'],
            'Tablets' => ['16 GB', '32 GB', '64 GB', '128 GB', '256 GB', '512 GB', '1 TB', '2 TB'],
            'Portátiles' => ['64 GB', '128 GB', '256 GB', '512 GB', '1 TB', '2 TB', '4 TB', '8 TB'],
            'PC Escritorio' => ['128 GB', '256 GB', '512 GB', '1 TB', '2 TB', '4 TB', '8 TB', '16 TB', '20 TB'],
            'Smartwatches' => ['4 GB', '8 GB', '16 GB', '32 GB', '64 GB', '128 GB'],
            'Discos SSD' => [
                '120 GB', '240 GB', '256 GB', '480 GB', '500 GB', '512 GB',
                '960 GB', '1 TB', '2 TB', '4 TB', '8 TB', '16 TB', '30 TB',
            ],
            'Discos HDD' => [
                '160 GB', '250 GB', '320 GB', '500 GB', '750 GB',
                '1 TB', '2 TB', '3 TB', '4 TB', '5 TB', '6 TB', '8 TB',
                '10 TB', '12 TB', '14 TB', '16 TB', '18 TB', '20 TB', '22 TB', '24 TB',
            ],
        ];

        foreach ($almacenamientos as $categoriaNombre => $storageList) {
            $catId = DB::table('categorias')->where('nombre', $categoriaNombre)->value('id');
            if (!$catId) continue;

            foreach ($storageList as $storage) {
                DB::table('almacenamientos')->insertOrIgnore([
                    'categoria_id' => $catId,
                    'nombre' => $storage,
                ]);
            }
        }
    }
}
