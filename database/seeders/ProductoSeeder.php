<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $celularesId = DB::table('categorias')->where('nombre', 'Celulares')->value('id');
        if (!$celularesId) {
            $this->command->warn('Categoria Celulares no encontrada. Ejecuta CategoriasSeeder primero.');
            return;
        }

        $productos = [
            // Samsung
            [
                'categoria_id' => $celularesId,
                'marca' => 'Samsung',
                'nombre' => 'Samsung Galaxy S25 Ultra',
                'descripcion' => 'El Samsung Galaxy S25 Ultra es el smartphone más avanzado de Samsung, con inteligencia artificial mejorada, cámara de 200MP y rendimiento excepcional.',
                'precio' => 5799000,
                'descuento' => 5,
                'stock' => 15,
                'tipo' => 'nuevo',
                'color' => 'Titanio',
                'ram' => '12 GB',
                'almacenamiento' => '512 GB',
                'imagenes' => json_encode(['samsung_s25_ultra.png', 'samsung_s25_ultra_2.png']),
                'caracteristicas' => "Procesador Snapdragon 8 Elite\nPantalla Dynamic AMOLED 2X 6.9\"\nCámara principal 200MP\nBatería 5000mAh\nCarga rápida 45W\nIP68\nS Pen integrado\nOne UI 7 basado en Android 15",
            ],
            [
                'categoria_id' => $celularesId,
                'marca' => 'Samsung',
                'nombre' => 'Samsung Galaxy S24',
                'descripcion' => 'Potencia y estilo en un diseño compacto. El Galaxy S24 ofrece rendimiento de primera con su procesador Exynos 2400.',
                'precio' => 2799000,
                'descuento' => 10,
                'stock' => 25,
                'tipo' => 'nuevo',
                'color' => 'Negro',
                'ram' => '8 GB',
                'almacenamiento' => '256 GB',
                'imagenes' => json_encode(['samsung_s24.png']),
                'caracteristicas' => "Procesador Exynos 2400\nPantalla Dynamic AMOLED 2X 6.2\"\nCámara triple 50MP+12MP+10MP\nBatería 4000mAh\nCarga rápida 25W\nIP68\nGalaxy AI\nOne UI 6.1",
            ],
            [
                'categoria_id' => $celularesId,
                'marca' => 'Samsung',
                'nombre' => 'Samsung Galaxy A55 5G',
                'descripcion' => 'El Galaxy A55 5G combina un diseño premium con características avanzadas a un precio accesible.',
                'precio' => 1599000,
                'descuento' => 0,
                'stock' => 30,
                'tipo' => 'nuevo',
                'color' => 'Azul',
                'ram' => '8 GB',
                'almacenamiento' => '256 GB',
                'imagenes' => json_encode(['samsung_a55.png']),
                'caracteristicas' => "Procesador Exynos 1480\nPantalla Super AMOLED 6.6\" 120Hz\nCámara triple 50MP+12MP+5MP\nBatería 5000mAh\nCarga rápida 25W\nIP67\nMarco de aluminio",
            ],
            [
                'categoria_id' => $celularesId,
                'marca' => 'Samsung',
                'nombre' => 'Samsung Galaxy Z Fold6',
                'descripcion' => 'La experiencia plegable definitiva. El Galaxy Z Fold6 combina una pantalla grande tipo tablet con la portabilidad de un smartphone.',
                'precio' => 7999000,
                'descuento' => 8,
                'stock' => 8,
                'tipo' => 'nuevo',
                'color' => 'Gris',
                'ram' => '12 GB',
                'almacenamiento' => '512 GB',
                'imagenes' => json_encode(['samsung_zfold6.png']),
                'caracteristicas' => "Procesador Snapdragon 8 Gen 3\nPantalla interna 7.6\" Dynamic AMOLED 2X\nPantalla externa 6.3\"\nCámara triple 50MP+12MP+10MP\nBatería 4400mAh\nIP48\nS Pen compatible\nMultitarea avanzada",
            ],

            // Apple
            [
                'categoria_id' => $celularesId,
                'marca' => 'Apple',
                'nombre' => 'iPhone 16 Pro Max',
                'descripcion' => 'El iPhone más potente de Apple con chip A18 Pro, sistema de cámara profesional y batería para todo el día.',
                'precio' => 6999000,
                'descuento' => 3,
                'stock' => 12,
                'tipo' => 'nuevo',
                'color' => 'Titanio Natural',
                'ram' => '8 GB',
                'almacenamiento' => '512 GB',
                'imagenes' => json_encode(['iphone_16_pro_max.png']),
                'caracteristicas' => "Chip A18 Pro (3nm)\nPantalla Super Retina XDR 6.9\" OLED 120Hz\nCámara triple 48MP+48MP+12MP\nTeleobjetivo 5x\nBatería hasta 33h reproducción video\nTitanio grado 5\nUSB-C 3.2 Gen 2\niOS 18\nApple Intelligence",
            ],
            [
                'categoria_id' => $celularesId,
                'marca' => 'Apple',
                'nombre' => 'iPhone 16 Pro',
                'descripcion' => 'Rendimiento profesional en un tamaño más compacto. Ideal para creadores de contenido y usuarios exigentes.',
                'precio' => 5799000,
                'descuento' => 0,
                'stock' => 18,
                'tipo' => 'nuevo',
                'color' => 'Blanco',
                'ram' => '8 GB',
                'almacenamiento' => '256 GB',
                'imagenes' => json_encode(['iphone_16_pro.png']),
                'caracteristicas' => "Chip A18 Pro (3nm)\nPantalla Super Retina XDR 6.3\" OLED 120Hz\nCámara triple 48MP+48MP+12MP\nTeleobjetivo 5x\nBatería hasta 27h reproducción video\nTitanio grado 5\nUSB-C 3.2 Gen 2\niOS 18\nApple Intelligence",
            ],
            [
                'categoria_id' => $celularesId,
                'marca' => 'Apple',
                'nombre' => 'iPhone 16',
                'descripcion' => 'El iPhone 16 trae el innovador botón de acción y el nuevo chip A18 para un rendimiento superior.',
                'precio' => 4299000,
                'descuento' => 5,
                'stock' => 22,
                'tipo' => 'nuevo',
                'color' => 'Azul',
                'ram' => '8 GB',
                'almacenamiento' => '128 GB',
                'imagenes' => json_encode(['iphone_16.png']),
                'caracteristicas' => "Chip A18 (3nm)\nPantalla Super Retina XDR 6.1\" OLED\nCámara dual 48MP+12MP\nBotón de Acción\nBatería hasta 22h reproducción video\nUSB-C\niOS 18\nApple Intelligence",
            ],
            [
                'categoria_id' => $celularesId,
                'marca' => 'Apple',
                'nombre' => 'iPhone 15',
                'descripcion' => 'El iPhone 15 con Dynamic Island, cámara de 48MP y el práctico puerto USB-C.',
                'precio' => 3499000,
                'descuento' => 10,
                'stock' => 20,
                'tipo' => 'nuevo',
                'color' => 'Rosa',
                'ram' => '6 GB',
                'almacenamiento' => '128 GB',
                'imagenes' => json_encode(['iphone_15.png']),
                'caracteristicas' => "Chip A16 Bionic\nPantalla Super Retina XDR 6.1\" OLED\nDynamic Island\nCámara principal 48MP\nBatería hasta 20h reproducción video\nUSB-C\nIP68\niOS 17",
            ],

            // Xiaomi
            [
                'categoria_id' => $celularesId,
                'marca' => 'Xiaomi',
                'nombre' => 'Xiaomi 14 Ultra',
                'descripcion' => 'El Xiaomi 14 Ultra redefine la fotografía móvil con su sistema de cámara Leica de cuatro lentes.',
                'precio' => 4499000,
                'descuento' => 7,
                'stock' => 10,
                'tipo' => 'nuevo',
                'color' => 'Negro',
                'ram' => '16 GB',
                'almacenamiento' => '512 GB',
                'imagenes' => json_encode(['xiaomi_14_ultra.png']),
                'caracteristicas' => "Procesador Snapdragon 8 Gen 3\nPantalla AMOLED WQHD+ 6.73\" 120Hz LTPO\nCámara cuádruple Leica 50MP+50MP+50MP+50MP\nBatería 5000mAh\nCarga rápida 90W\nCarga inalámbrica 80W\nIP68\nHyperOS",
            ],
            [
                'categoria_id' => $celularesId,
                'marca' => 'Xiaomi',
                'nombre' => 'Xiaomi Redmi Note 14 Pro+',
                'descripcion' => 'El Redmi Note 14 Pro+ ofrece características premium a un precio imbatible.',
                'precio' => 1499000,
                'descuento' => 0,
                'stock' => 35,
                'tipo' => 'nuevo',
                'color' => 'Verde',
                'ram' => '8 GB',
                'almacenamiento' => '256 GB',
                'imagenes' => json_encode(['redmi_note_14_pro.png']),
                'caracteristicas' => "Procesador MediaTek Dimensity 7200\nPantalla AMOLED 6.67\" 120Hz\nCámara triple 200MP+8MP+2MP\nBatería 5000mAh\nCarga rápida 67W\nIP68\nHyperOS\nCorning Gorilla Glass Victus",
            ],

            // Motorola
            [
                'categoria_id' => $celularesId,
                'marca' => 'Motorola',
                'nombre' => 'Motorola Edge 50 Ultra',
                'descripcion' => 'El Motorola Edge 50 Ultra combina un diseño elegante con características fotográficas avanzadas.',
                'precio' => 2999000,
                'descuento' => 5,
                'stock' => 14,
                'tipo' => 'nuevo',
                'color' => 'Negro',
                'ram' => '12 GB',
                'almacenamiento' => '512 GB',
                'imagenes' => json_encode(['moto_edge_50_ultra.png']),
                'caracteristicas' => "Procesador Snapdragon 8s Gen 3\nPantalla P-OLED 6.7\" 144Hz\nCámara triple 50MP+50MP+64MP teleobjetivo\nBatería 4500mAh\nCarga rápida 125W\nCarga inalámbrica 50W\nIP68\nAndroid 14\nHello UI",
            ],
            [
                'categoria_id' => $celularesId,
                'marca' => 'Motorola',
                'nombre' => 'Motorola Moto G85 5G',
                'descripcion' => 'El Moto G85 5G trae conectividad de última generación y un rendimiento equilibrado para el día a día.',
                'precio' => 899000,
                'descuento' => 0,
                'stock' => 40,
                'tipo' => 'nuevo',
                'color' => 'Gris',
                'ram' => '8 GB',
                'almacenamiento' => '256 GB',
                'imagenes' => json_encode(['moto_g85.png']),
                'caracteristicas' => "Procesador Snapdragon 6s Gen 3\nPantalla P-OLED 6.67\" 120Hz\nCámara dual 50MP+8MP\nBatería 5000mAh\nCarga rápida 30W\nAndroid 14\nMotorola Ready For",
            ],
        ];

        foreach ($productos as $producto) {
            $producto['created_at'] = now();
            $producto['updated_at'] = now();
            $producto['visitas'] = 0;
            $producto['estado'] = 1;

            DB::table('productos')->insert($producto);
        }

        $this->command->info(count($productos) . ' productos creados exitosamente.');
    }
}
