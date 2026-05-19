<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $capacidades = [
            '2GB', '3GB', '4GB', '6GB', '8GB', '12GB', '16GB', 
            '24GB', '32GB', '64GB', '128GB', '256GB'
        ];

        foreach ($capacidades as $capacidad) {
            \App\Models\Ram::create([
                'capacidad' => $capacidad
            ]);
        }
    }
}