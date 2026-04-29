<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlmacenamientosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('almacenamientos')->insert([
            ['capacidad' => '32 GB'],
            ['capacidad' => '64 GB'],
            ['capacidad' => '128 GB'],
            ['capacidad' => '256 GB'],
            ['capacidad' => '512 GB'],
            ['capacidad' => '1 TB'],
        ]);
    }
}