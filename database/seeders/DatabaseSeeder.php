<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UsuariosSeeder::class,
            MarcasSeeder::class,
            ColoresSeeder::class,
            AlmacenamientosSeeder::class,
            CategoriasSeeder::class,
            ServiciosSeeder::class,
        ]);
    }
}