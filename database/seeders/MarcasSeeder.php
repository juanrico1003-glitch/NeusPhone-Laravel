<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('marcas')->insert([
            ['nombre' => 'Samsung'],
            ['nombre' => 'Apple'],
            ['nombre' => 'Huawei'],
            ['nombre' => 'Xiaomi'],
            ['nombre' => 'Dell'],
            ['nombre' => 'HP'],
            ['nombre' => 'Lenovo'],
            ['nombre' => 'Sony'],
            ['nombre' => 'Bose'],
            ['nombre' => 'Logitech'],
        ]);
    }
}