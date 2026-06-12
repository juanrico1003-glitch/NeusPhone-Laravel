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
            'rol_id' => 1,
            'nombres' => 'Admin',
            'apellidos' => 'NeusPhone',
            'cedula' => '0000000000',
            'correo' => 'phoneneus@gmail.com',
            'fecha_nacimiento' => '2001-01-01',
            'password' => Hash::make('admin123'),
            'estado' => 1,
        ]);
    }
}