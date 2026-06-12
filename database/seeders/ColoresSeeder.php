<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColoresSeeder extends Seeder
{
    public function run(): void
    {
        $colores = [
            'Negro', 'Blanco', 'Gris', 'Plateado', 'Dorado',
            'Azul', 'Rojo', 'Verde', 'Amarillo', 'Naranja',
            'Rosa', 'Morado', 'Violeta', 'Turquesa', 'Cian',
            'Marrón', 'Beige', 'Crema', 'Coral', 'Lavanda',
            'Menta', 'Oliva', 'Mostaza', 'Borgoña', 'Granate',
            'Carbón', 'Titanio', 'Grafito', 'Aluminio', 'Bronce',
            'Cobre', 'Champán', 'Blanco Perla', 'Negro Mate',
            'Azul Medianoche', 'Verde Esmeralda', 'Rojo Rubí',
            'Azul Celeste', 'Gris Espacial', 'Rosa Oro',
            'Azul Zafiro', 'Verde Bosque', 'Púrpura', 'Transparente',
        ];

        foreach ($colores as $color) {
            DB::table('colores')->insertOrIgnore(['nombre' => $color]);
        }
    }
}
