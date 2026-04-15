<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('usuarios')->insert([
            [
                'rol_id' => 1,
                'nombres' => 'Juan',
                'apellidos' => 'Rico',
                'cedula' => '1003700214',
                'correo' => 'juanrico1003@gmail.com',
                'fecha_nacimiento' => '2001-02-03',
                'password' => Hash::make('12345678'),
                'estado' => 1,
            ],
            [
                'rol_id' => 2,
                'nombres' => 'Andres',
                'apellidos' => 'Delgadillo',
                'cedula' => '1003700215',
                'correo' => 'ricojuancho1331@gmail.com',
                'fecha_nacimiento' => '2001-03-02',
                'password' => Hash::make('87654321'),
                'estado' => 1,
            ],
        ]);
    }
}