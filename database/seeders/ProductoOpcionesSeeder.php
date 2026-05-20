<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoOpcionesSeeder extends Seeder
{
    public function run(): void
    {
        $colores = [
            'Negro', 'Blanco', 'Gris', 'Azul', 'Rojo', 'Verde', 'Amarillo', 'Dorado', 'Plateado'
        ];
        $marcas = [
            'Samsung', 'Apple', 'Huawei', 'Xiaomi', 'Dell', 'HP', 'Lenovo', 'Sony', 'Bose', 'Logitech'
        ];
        $almacenamientos = [
            '32 GB', '64 GB', '128 GB', '256 GB', '512 GB', '1 TB'
        ];
        $rams = [
            '2GB', '3GB', '4GB', '6GB', '8GB', '12GB', '16GB', '24GB', '32GB', '64GB', '128GB', '256GB'
        ];
    }

    public static function colores() { return [
        'Negro', 'Blanco', 'Gris', 'Azul', 'Rojo', 'Verde', 'Amarillo', 'Dorado', 'Plateado'
    ]; }
    public static function marcas() { return [
        'Samsung', 'Apple', 'Huawei', 'Xiaomi', 'Dell', 'HP', 'Lenovo', 'Sony', 'Bose', 'Logitech'
    ]; }
    public static function almacenamientos() { return [
        '32 GB', '64 GB', '128 GB', '256 GB', '512 GB', '1 TB'
    ]; }
    public static function rams() { return [
        '2GB', '3GB', '4GB', '6GB', '8GB', '12GB', '16GB', '24GB', '32GB', '64GB', '128GB', '256GB'
    ]; }
}
