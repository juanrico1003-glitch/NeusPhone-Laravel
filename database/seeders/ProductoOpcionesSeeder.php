<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoOpcionesSeeder extends Seeder
{
    public function run(): void
    {
        // Colores
        foreach (self::colores() as $color) {
            DB::table('colores')->insertOrIgnore(['nombre' => $color]);
        }

        // Marcas
        foreach (self::marcas() as $categoriaNombre => $brands) {
            $catId = DB::table('categorias')->where('nombre', $categoriaNombre)->value('id');
            if (!$catId) continue;

            foreach ($brands as $brand) {
                DB::table('marcas')->insertOrIgnore([
                    'categoria_id' => $catId,
                    'nombre' => $brand,
                ]);
            }
        }

        // Rams
        foreach (self::rams() as $categoriaNombre => $ramList) {
            $catId = DB::table('categorias')->where('nombre', $categoriaNombre)->value('id');
            if (!$catId) continue;

            foreach ($ramList as $ram) {
                DB::table('rams')->insertOrIgnore([
                    'categoria_id' => $catId,
                    'nombre' => $ram,
                ]);
            }
        }

        // Almacenamientos
        foreach (self::almacenamientos() as $categoriaNombre => $storageList) {
            $catId = DB::table('categorias')->where('nombre', $categoriaNombre)->value('id');
            if (!$catId) continue;

            foreach ($storageList as $storage) {
                DB::table('almacenamientos')->insertOrIgnore([
                    'categoria_id' => $catId,
                    'nombre' => $storage,
                ]);
            }
        }

        // Procesadores
        foreach (self::procesadores() as $categoriaNombre => $lista) {
            $catId = DB::table('categorias')->where('nombre', $categoriaNombre)->value('id');
            if (!$catId) continue;

            foreach ($lista as $nombre) {
                DB::table('procesadores')->insertOrIgnore([
                    'categoria_id' => $catId,
                    'nombre' => $nombre,
                ]);
            }
        }

        // Tarjetas graficas
        foreach (self::tarjetasGraficas() as $categoriaNombre => $lista) {
            $catId = DB::table('categorias')->where('nombre', $categoriaNombre)->value('id');
            if (!$catId) continue;

            foreach ($lista as $nombre) {
                DB::table('tarjetas_graficas')->insertOrIgnore([
                    'categoria_id' => $catId,
                    'nombre' => $nombre,
                ]);
            }
        }

        // Field configs
        foreach (self::fieldConfigs() as $categoriaNombre => $campos) {
            $catId = DB::table('categorias')->where('nombre', $categoriaNombre)->value('id');
            if (!$catId) continue;

            foreach ($campos as $campo) {
                DB::table('category_field_configs')->insertOrIgnore([
                    'categoria_id' => $catId,
                    'campo' => $campo,
                ]);
            }
        }

    }

    public static function procesadores()
    {
        return [
            'Laptop' => [
                'Intel Celeron N4020', 'Intel Celeron N4120', 'Intel Celeron N4500', 'Intel Celeron N5100',
                'Intel Pentium Silver N5030', 'Intel Pentium Gold 7505',
                'Intel Core i3-1115G4', 'Intel Core i3-1215U', 'Intel Core i3-1315U', 'Intel Core i3-1415U',
                'Intel Core i5-1135G7', 'Intel Core i5-11400H', 'Intel Core i5-1235U', 'Intel Core i5-12450H',
                'Intel Core i5-12500H', 'Intel Core i5-1335U', 'Intel Core i5-13420H', 'Intel Core i5-13500H',
                'Intel Core i5-14350H', 'Intel Core i5-14450H', 'Intel Core i5-14500H',
                'Intel Core 5 210H', 'Intel Core 5 220H',
                'Intel Core 7 240H', 'Intel Core 7 250H', 'Intel Core 7 260H', 'Intel Core 7 265H',
                'Intel Core 9 270H', 'Intel Core 9 275HX',
                'Intel Core i7-1165G7', 'Intel Core i7-11800H', 'Intel Core i7-1260P', 'Intel Core i7-12700H',
                'Intel Core i7-12800H', 'Intel Core i7-1360P', 'Intel Core i7-13620H', 'Intel Core i7-13700H',
                'Intel Core i7-13700HX', 'Intel Core i7-14650HX', 'Intel Core i7-14700HX',
                'Intel Core i9-11980HK', 'Intel Core i9-12900H', 'Intel Core i9-12900HK',
                'Intel Core i9-13900H', 'Intel Core i9-13900HK', 'Intel Core i9-13980HX',
                'Intel Core i9-14900HX', 'Intel Core i9-14900H',
                'Intel Core Ultra 5 125H', 'Intel Core Ultra 5 225H', 'Intel Core Ultra 5 225HX', 'Intel Core Ultra 5 226V',
                'Intel Core Ultra 7 155H', 'Intel Core Ultra 7 255H', 'Intel Core Ultra 7 255HX', 'Intel Core Ultra 7 256V', 'Intel Core Ultra 7 258V',
                'Intel Core Ultra 9 185H', 'Intel Core Ultra 9 285H', 'Intel Core Ultra 9 285HX', 'Intel Core Ultra 9 288V',
                'AMD Ryzen 3 5300U', 'AMD Ryzen 3 5425U', 'AMD Ryzen 3 7320U', 'AMD Ryzen 3 7330U',
                'AMD Ryzen 5 5500U', 'AMD Ryzen 5 5600H', 'AMD Ryzen 5 6600U', 'AMD Ryzen 5 6600H',
                'AMD Ryzen 5 7530U', 'AMD Ryzen 5 7535HS', 'AMD Ryzen 5 7600H', 'AMD Ryzen 5 7640HS',
                'AMD Ryzen 5 8540U', 'AMD Ryzen 5 8640HS', 'AMD Ryzen 5 8645HS',
                'AMD Ryzen 7 5700U', 'AMD Ryzen 7 5800H', 'AMD Ryzen 7 6800U', 'AMD Ryzen 7 6800H',
                'AMD Ryzen 7 7730U', 'AMD Ryzen 7 7735HS', 'AMD Ryzen 7 7800H', 'AMD Ryzen 7 7840HS',
                'AMD Ryzen 7 8745HS', 'AMD Ryzen 7 8840HS', 'AMD Ryzen 7 8845HS',
                'AMD Ryzen 3 210', 'AMD Ryzen 5 240', 'AMD Ryzen 5 250',
                'AMD Ryzen 7 260', 'AMD Ryzen 7 270', 'AMD Ryzen 9 280',
                'AMD Ryzen AI 7 350', 'AMD Ryzen AI 9 365', 'AMD Ryzen AI 9 HX 370', 'AMD Ryzen AI 9 HX 375',
                'AMD Ryzen AI Max 385', 'AMD Ryzen AI Max 390', 'AMD Ryzen AI Max+ 395',
                'AMD Ryzen 9 5900HX', 'AMD Ryzen 9 5980HX', 'AMD Ryzen 9 6900HX', 'AMD Ryzen 9 6980HX',
                'AMD Ryzen 9 7940HS', 'AMD Ryzen 9 7945HX', 'AMD Ryzen 9 8945HS', 'AMD Ryzen 9 8945HX',
                'AMD Ryzen 9 9955HX',
                'Apple M1', 'Apple M1 Pro', 'Apple M1 Max', 'Apple M1 Ultra',
                'Apple M2', 'Apple M2 Pro', 'Apple M2 Max', 'Apple M2 Ultra',
                'Apple M3', 'Apple M3 Pro', 'Apple M3 Max', 'Apple M3 Ultra',
                'Apple M4', 'Apple M4 Pro', 'Apple M4 Max',
            ],
            'PC Escritorio' => [
                'Intel Core i3-10100', 'Intel Core i3-10105F', 'Intel Core i3-12100', 'Intel Core i3-12100F',
                'Intel Core i3-13100', 'Intel Core i3-13100F', 'Intel Core i3-14100', 'Intel Core i3-14100F',
                'Intel Core i5-10400', 'Intel Core i5-10400F', 'Intel Core i5-11400', 'Intel Core i5-11400F',
                'Intel Core i5-12400', 'Intel Core i5-12400F', 'Intel Core i5-12600K', 'Intel Core i5-12600KF',
                'Intel Core i5-13400', 'Intel Core i5-13400F', 'Intel Core i5-13600K', 'Intel Core i5-13600KF',
                'Intel Core i5-14400', 'Intel Core i5-14400F', 'Intel Core i5-14600K', 'Intel Core i5-14600KF',
                'Intel Core i7-10700', 'Intel Core i7-10700K', 'Intel Core i7-11700', 'Intel Core i7-11700K',
                'Intel Core i7-12700', 'Intel Core i7-12700K', 'Intel Core i7-12700KF',
                'Intel Core i7-13700', 'Intel Core i7-13700K', 'Intel Core i7-13700KF',
                'Intel Core i7-14700', 'Intel Core i7-14700K', 'Intel Core i7-14700KF',
                'Intel Core i9-10900', 'Intel Core i9-10900K', 'Intel Core i9-11900K',
                'Intel Core i9-12900', 'Intel Core i9-12900K', 'Intel Core i9-12900KS',
                'Intel Core i9-13900', 'Intel Core i9-13900K', 'Intel Core i9-13900KS',
                'Intel Core i9-14900', 'Intel Core i9-14900K', 'Intel Core i9-14900KS',
                'Intel Core i9-15900K',
                'Intel Core Ultra 5 225', 'Intel Core Ultra 5 235',
                'Intel Core Ultra 7 265', 'Intel Core Ultra 7 265F', 'Intel Core Ultra 7 265KF',
                'Intel Core Ultra 9 285', 'Intel Core Ultra 9 285K', 'Intel Core Ultra 9 285KF',
                'Intel Xeon E3-1230', 'Intel Xeon E-2278G', 'Intel Xeon E-2378', 'Intel Xeon E-2488',
                'Intel Xeon W-2245', 'Intel Xeon W-3245',
                'AMD Ryzen 3 3100', 'AMD Ryzen 3 3300X', 'AMD Ryzen 3 4100', 'AMD Ryzen 3 4300G',
                'AMD Ryzen 3 5100', 'AMD Ryzen 3 5300G', 'AMD Ryzen 3 7100', 'AMD Ryzen 3 7300X',
                'AMD Ryzen 5 3600', 'AMD Ryzen 5 5600', 'AMD Ryzen 5 5600X', 'AMD Ryzen 5 5600G',
                'AMD Ryzen 5 7500F', 'AMD Ryzen 5 7600', 'AMD Ryzen 5 7600X', 'AMD Ryzen 5 8400F',
                'AMD Ryzen 5 8600G', 'AMD Ryzen 5 9600', 'AMD Ryzen 5 9600X',
                'AMD Ryzen 7 3700X', 'AMD Ryzen 7 5700X', 'AMD Ryzen 7 5700X3D', 'AMD Ryzen 7 5800X',
                'AMD Ryzen 7 5800X3D', 'AMD Ryzen 7 7700', 'AMD Ryzen 7 7700X', 'AMD Ryzen 7 7800X3D',
                'AMD Ryzen 7 8700G', 'AMD Ryzen 7 9700X', 'AMD Ryzen 7 9800X3D',
                'AMD Ryzen 9 3900X', 'AMD Ryzen 9 3950X', 'AMD Ryzen 9 5900X', 'AMD Ryzen 9 5950X',
                'AMD Ryzen 9 7900', 'AMD Ryzen 9 7900X', 'AMD Ryzen 9 7950X', 'AMD Ryzen 9 7950X3D',
                'AMD Ryzen 9 9900X', 'AMD Ryzen 9 9900X3D', 'AMD Ryzen 9 9950X', 'AMD Ryzen 9 9950X3D', 'AMD Ryzen 9 9960X',
                'AMD Ryzen 9 9955HX (Desktop)',
                'AMD Ryzen Threadripper 3960X', 'AMD Ryzen Threadripper 3970X', 'AMD Ryzen Threadripper 3990X',
                'AMD Ryzen Threadripper 5965WX', 'AMD Ryzen Threadripper 5975WX', 'AMD Ryzen Threadripper 5980X',
                'AMD Ryzen Threadripper 5995WX', 'AMD Ryzen Threadripper 7960X', 'AMD Ryzen Threadripper 7970X',
                'AMD Ryzen Threadripper 7980X',
                'AMD Athlon 3000G', 'AMD Athlon Gold 3150G', 'AMD Athlon Silver 3050G',
            ],
        ];
    }

    public static function tarjetasGraficas()
    {
        return [
            'Laptop' => [
                'NVIDIA GeForce RTX 2050', 'NVIDIA GeForce RTX 3050', 'NVIDIA GeForce RTX 3050 Ti',
                'NVIDIA GeForce RTX 3060', 'NVIDIA GeForce RTX 3070', 'NVIDIA GeForce RTX 3070 Ti',
                'NVIDIA GeForce RTX 3080', 'NVIDIA GeForce RTX 3080 Ti',
                'NVIDIA GeForce RTX 4050', 'NVIDIA GeForce RTX 4060', 'NVIDIA GeForce RTX 4070',
                'NVIDIA GeForce RTX 4080', 'NVIDIA GeForce RTX 4090',
                'NVIDIA GeForce RTX 5050', 'NVIDIA GeForce RTX 5060', 'NVIDIA GeForce RTX 5070', 'NVIDIA GeForce RTX 5070 Ti',
                'NVIDIA GeForce RTX 5080', 'NVIDIA GeForce RTX 5090',
                'NVIDIA GeForce MX350', 'NVIDIA GeForce MX450', 'NVIDIA GeForce MX550', 'NVIDIA GeForce MX570',
                'NVIDIA GeForce GTX 1650', 'NVIDIA GeForce GTX 1650 Ti', 'NVIDIA GeForce GTX 1660 Ti',
                'AMD Radeon RX 6300M', 'AMD Radeon RX 6400M', 'AMD Radeon RX 6450M',
                'AMD Radeon RX 6500M', 'AMD Radeon RX 6550M', 'AMD Radeon RX 6600M', 'AMD Radeon RX 6600S', 'AMD Radeon RX 6650M',
                'AMD Radeon RX 6700M', 'AMD Radeon RX 6800M', 'AMD Radeon RX 6800S',
                'AMD Radeon RX 7600M', 'AMD Radeon RX 7600M XT', 'AMD Radeon RX 7700M', 'AMD Radeon RX 7800M',
                'Intel Arc A310M', 'Intel Arc A350M', 'Intel Arc A370M', 'Intel Arc A530M', 'Intel Arc A550M',
                'Intel Arc A730M', 'Intel Arc A770M', 'Intel Arc B570M', 'Intel Arc B580M',
                'Apple M1 GPU (7 núcleos)', 'Apple M1 GPU (8 núcleos)',
                'Apple M1 Pro GPU (14 núcleos)', 'Apple M1 Pro GPU (16 núcleos)',
                'Apple M1 Max GPU (24 núcleos)', 'Apple M1 Max GPU (32 núcleos)',
                'Apple M1 Ultra GPU (48 núcleos)', 'Apple M1 Ultra GPU (64 núcleos)',
                'Apple M2 GPU (8 núcleos)', 'Apple M2 GPU (10 núcleos)',
                'Apple M2 Pro GPU (16 núcleos)', 'Apple M2 Pro GPU (19 núcleos)',
                'Apple M2 Max GPU (30 núcleos)', 'Apple M2 Max GPU (38 núcleos)',
                'Apple M2 Ultra GPU (60 núcleos)', 'Apple M2 Ultra GPU (76 núcleos)',
                'Apple M3 GPU (8 núcleos)', 'Apple M3 GPU (10 núcleos)',
                'Apple M3 Pro GPU (14 núcleos)', 'Apple M3 Pro GPU (18 núcleos)',
                'Apple M3 Max GPU (30 núcleos)', 'Apple M3 Max GPU (40 núcleos)',
                'Apple M3 Ultra GPU (64 núcleos)', 'Apple M3 Ultra GPU (80 núcleos)',
                'Apple M4 GPU (8 núcleos)', 'Apple M4 GPU (10 núcleos)',
                'Intel UHD Graphics', 'Intel Iris Xe Graphics', 'Intel Iris Graphics',
                'AMD Radeon Graphics (Vega integrado)', 'AMD Radeon 660M', 'AMD Radeon 680M',
                'AMD Radeon 740M', 'AMD Radeon 760M', 'AMD Radeon 780M', 'AMD Radeon 880M', 'AMD Radeon 890M',
            ],
            'PC Escritorio' => [
                'NVIDIA GeForce RTX 5060', 'NVIDIA GeForce RTX 5060 Ti',
                'NVIDIA GeForce RTX 5070', 'NVIDIA GeForce RTX 5070 Ti',
                'NVIDIA GeForce RTX 5080', 'NVIDIA GeForce RTX 5080 Ti',
                'NVIDIA GeForce RTX 5090', 'NVIDIA GeForce RTX 5090 Ti',
                'NVIDIA GeForce RTX 4060', 'NVIDIA GeForce RTX 4060 Ti',
                'NVIDIA GeForce RTX 4070', 'NVIDIA GeForce RTX 4070 Super', 'NVIDIA GeForce RTX 4070 Ti', 'NVIDIA GeForce RTX 4070 Ti Super',
                'NVIDIA GeForce RTX 4080', 'NVIDIA GeForce RTX 4080 Super', 'NVIDIA GeForce RTX 4090', 'NVIDIA GeForce RTX 4090 D',
                'NVIDIA GeForce RTX 3050', 'NVIDIA GeForce RTX 3060', 'NVIDIA GeForce RTX 3060 Ti',
                'NVIDIA GeForce RTX 3070', 'NVIDIA GeForce RTX 3070 Ti', 'NVIDIA GeForce RTX 3080', 'NVIDIA GeForce RTX 3080 Ti',
                'NVIDIA GeForce RTX 3090', 'NVIDIA GeForce RTX 3090 Ti',
                'NVIDIA GeForce RTX 2060', 'NVIDIA GeForce RTX 2060 Super',
                'NVIDIA GeForce RTX 2070', 'NVIDIA GeForce RTX 2070 Super',
                'NVIDIA GeForce RTX 2080', 'NVIDIA GeForce RTX 2080 Super', 'NVIDIA GeForce RTX 2080 Ti',
                'NVIDIA GeForce GTX 1630', 'NVIDIA GeForce GTX 1650', 'NVIDIA GeForce GTX 1650 Super',
                'NVIDIA GeForce GTX 1660', 'NVIDIA GeForce GTX 1660 Super', 'NVIDIA GeForce GTX 1660 Ti',
                'NVIDIA RTX 2000 Ada', 'NVIDIA RTX 4000 Ada', 'NVIDIA RTX 4500 Ada', 'NVIDIA RTX 5000 Ada',
                'NVIDIA RTX 6000 Ada', 'NVIDIA RTX A2000', 'NVIDIA RTX A4000', 'NVIDIA RTX A5000', 'NVIDIA RTX A6000',
                'NVIDIA Quadro P620', 'NVIDIA Quadro P1000', 'NVIDIA Quadro P2200', 'NVIDIA Quadho P4000',
                'NVIDIA Quadro RTX 4000', 'NVIDIA Quadho RTX 5000', 'NVIDIA Quadro RTX 6000', 'NVIDIA Quadro RTX 8000',
                'AMD Radeon RX 9060 XT', 'AMD Radeon RX 9070', 'AMD Radeon RX 9070 XT', 'AMD Radeon RX 9070 GRE',
                'AMD Radeon RX 9080', 'AMD Radeon RX 9080 XT', 'AMD Radeon RX 9090 XT',
                'AMD Radeon RX 7600', 'AMD Radeon RX 7600 XT', 'AMD Radeon RX 7700 XT',
                'AMD Radeon RX 7800 XT', 'AMD Radeon RX 7900 GRE', 'AMD Radeon RX 7900 XT', 'AMD Radeon RX 7900 XTX', 'AMD Radeon Pro W7900',
                'AMD Radeon RX 6400', 'AMD Radeon RX 6500 XT', 'AMD Radeon RX 6600', 'AMD Radeon RX 6600 XT', 'AMD Radeon RX 6650 XT',
                'AMD Radeon RX 6700 XT', 'AMD Radeon RX 6750 XT', 'AMD Radeon RX 6800', 'AMD Radeon RX 6800 XT',
                'AMD Radeon RX 6900 XT', 'AMD Radeon RX 6950 XT', 'Intel Arc A380', 'Intel Arc A580', 'Intel Arc A750', 'Intel Arc A770', 'Intel Arc A770 16GB',
            ],
        ];
    }
    public static function colores()
    {
        return [
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
    }

    public static function marcas()
    {
        return [
            'Celulares' => [
                'Samsung', 'Apple', 'Xiaomi', 'Huawei', 'Oppo',
                'Vivo', 'OnePlus', 'Google', 'Motorola', 'Nokia',
                'Sony', 'LG', 'Realme', 'Honor', 'Nothing',
                'Asus', 'ZTE', 'Alcatel', 'TCL', 'Infinix',
                'Tecno', 'Itel', 'Micromax', 'Lava', 'BLU',
                'CAT', 'Ulefone', 'Doogee', 'Blackview', 'Oukitel',
                'Cubot', 'Meizu', 'Lenovo', 'HTC', 'Fairphone',
                'Sharp', 'Panasonic', 'Energizer', 'Emporia', 'Doro',
            ],
            'Tablets' => [
                'Samsung', 'Apple', 'Huawei', 'Lenovo', 'Xiaomi',
                'Amazon', 'Microsoft', 'Google', 'Nokia', 'Sony',
                'LG', 'Asus', 'Acer', 'Realme', 'Honor',
                'TCL', 'Alcatel', 'Blackview', 'Teclast', 'Cube',
                'Doogee', 'Oukitel', 'Vastking', 'Dragon Touch', 'Huion',
                'Wacom', 'Xp Pen', 'Kamvas',
            ],
            'Laptop' => [
                'Acer', 'Alienware', 'Apple', 'AORUS', 'ASRock', 'Asus',
                'Avita', 'Clevo', 'Chuwi', 'Corsair', 'CyberPowerPC', 'Dell',
                'Dynabook', 'Fujitsu', 'Framework', 'Gigabyte', 'Google', 'GPD',
                'Hasee', 'Honor', 'HP', 'Huawei', 'Intel', 'Jumper',
                'LG', 'Lenovo', 'Maingear', 'Medion', 'Microsoft', 'Minisforum',
                'MSI', 'NZXT', 'One Netbook', 'Origin PC', 'Panasonic', 'Razer',
                'Samsung', 'Schenker', 'System76', 'Toshiba', 'Tuxedo', 'VAIO',
                'Velocity Micro', 'Xiaomi', 'XMG', 'Zotac',
            ],
            'PC Escritorio' => [
                'Acer', 'Alienware', 'Apple', 'ASRock', 'Asus', 'Azulle',
                'Beelink', 'CLX', 'Cooler Master', 'Corsair', 'CyberPowerPC', 'Dell',
                'Digital Storm', 'Falcon Northwest', 'Gigabyte', 'HP', 'iBuyPower',
                'Intel', 'Lenovo', 'Maingear', 'Minisforum', 'MSI', 'NZXT',
                'Origin PC', 'Puget Systems', 'Samsung', 'Shuttle', 'Skytech',
                'Thermaltake', 'Velztorm', 'Zotac',
            ],
            'Monitores' => [
                'Dell', 'LG', 'Samsung', 'BenQ', 'Asus',
                'Acer', 'MSI', 'Gigabyte', 'HP', 'Lenovo',
                'Philips', 'ViewSonic', 'AOC', 'Sony', 'Eizo',
                'NEC', 'Apple', 'HKC', 'Xiaomi', 'Huawei',
                'Sceptre', 'Viotek', 'Alienware', 'Corsair', 'Razer',
                'G-Story', 'INNOCN', 'KTC', 'Redragon', 'Cooler Master',
            ],
            'Televisores' => [
                'Samsung', 'LG', 'Sony', 'Panasonic', 'TCL',
                'Hisense', 'Philips', 'Sharp', 'Vizio', 'Skyworth',
                'Xiaomi', 'Huawei', 'Toshiba', 'Haier', 'JVC',
                'Grundig', 'Ferguson', 'Daewoo', 'Sanyo', 'Hitachi',
                'Mitsubishi', 'Bang & Olufsen', 'Loewe', 'Changhong', 'Konka',
            ],
            'Smartwatches' => [
                'Apple', 'Samsung', 'Garmin', 'Fitbit (Google)', 'Huawei',
                'Xiaomi', 'Amazfit', 'Realme', 'Oppo', 'Honor',
                'Google (Pixel)', 'Suunto', 'Polar', 'Coros', 'Withings',
                'Fossil', 'Mobvoi (TicWatch)', 'Skagen', 'Michael Kors', 'Hublot',
                'Tag Heuer', 'Montblanc', 'OnePlus', 'CMF by Nothing', 'Hayo',
                'Diesel', 'Emporio Armani', 'Citizen', 'Garmin',
            ],
            'Audífonos' => [
                'Sony', 'Bose', 'Sennheiser', 'Audio-Technica', 'Beyerdynamic',
                'AKG (Samsung)', 'JBL', 'Skullcandy', 'Beats (Apple)', 'Anker (Soundcore)',
                'Jabra', 'Shure', 'Marshall', 'Philips', 'Razer',
                'Corsair', 'HyperX (HP)', 'Logitech', 'SteelSeries', 'Edifier',
                'Koss', 'Grado', 'Status Audio', 'Nothing', '1MORE',
                'Etymotic', 'Campfire Audio', 'Focal', 'Meze', 'HiFiMAN',
                'Audeze', 'Dan Clark Audio', 'Moondrop', 'Truthear', '7Hz',
                'Samsung (Harman)', 'Bang & Olufsen', 'Bowers & Wilkins', 'Devialet', 'Klipsch',
            ],
            'Parlantes y Equipos de Sonido' => [
                'JBL', 'Sony', 'Bose', 'Sonos', 'Marshall',
                'Harman Kardon', 'Bang & Olufsen', 'Anker (Soundcore)', 'Ultimate Ears', 'LG',
                'Samsung (Harman)', 'Edifier', 'Philips', 'Panasonic', 'Sennheiser',
                'Creative', 'Logitech', 'Razer', 'Denon', 'Yamaha',
                'JVC', 'Pioneer', 'Klipsch', 'Polk Audio', 'Bowers & Wilkins',
                'KEF', 'Dali', 'ELAC', 'Focal', 'Wharfedale',
                'Monitor Audio', 'Altec Lansing', 'ION Audio', 'DOSS', 'Tronsmart',
                'Soundcore', 'Tribit', 'EcoFlow', 'Audio Pro',
            ],
            'Radios' => [
                'Sony', 'Panasonic', 'Philips', 'Sangean', 'Tecsun',
                'Grundig', 'Bosch', 'Uniden', 'Cobra', 'Midland',
                'Baofeng', 'Yaesu', 'ICOM', 'Kenwood', 'Motorola',
                'Hytera', 'Entel', 'JVC', 'Retevis', 'Klein Electronics',
                'Eton', 'C. Crane', 'CCRadio', 'Degen', 'Radiwow',
            ],
            'Memorias RAM' => [
                'Corsair', 'G.Skill', 'Kingston', 'Crucial (Micron)', 'Samsung',
                'SK Hynix', 'TeamGroup', 'ADATA (XPG)', 'Patriot (Viper)', 'Silicon Power',
                'PNY', 'GeIL', 'Mushkin', 'OLOy', 'Thermaltake',
                'KLEVV (ESSENCORE)', 'V-Color', 'Neo Forza', 'Apacer', 'Transcend',
                'Micron', 'Nanya', 'Qimonda', 'Hynix',
            ],
            'Discos SSD' => [
                'Samsung', 'Western Digital (WD)', 'Crucial (Micron)', 'Kingston', 'SK Hynix (Solidigm)',
                'Seagate', 'Corsair', 'ADATA (XPG)', 'TeamGroup', 'Sabrent',
                'PNY', 'Transcend', 'Patriot', 'Gigabyte', 'Silicon Power',
                'Lexar', 'Netac', 'Fanxiang', 'Timetec', 'Mushkin',
                'Intel', 'Micron', 'Toshiba (Kioxia)', 'Biwin', 'Acer',
                'HP', 'Lenovo', 'Addlink', 'Inland', 'ORICO',
            ],
            'Discos HDD' => [
                'Seagate', 'Western Digital (WD)', 'Toshiba', 'Hitachi (HGST)', 'Samsung',
                'Maxtor', 'Fujitsu', 'ExcelStor',
            ],
            'Tarjetas Gráficas' => [
                'AMD', 'AFOX', 'ASRock', 'Asus', 'BIOSTAR', 'Club 3D', 'Colorful',
                'Diamond', 'ELSA', 'EVGA', 'Gainward', 'Galax', 'Gigabyte',
                'HIS', 'Inno3D', 'Leadtek', 'Manli', 'Maxsun', 'MSI',
                'Nvidia', 'Palit', 'PNY', 'PowerColor', 'Sapphire', 'Sparkle',
                'Triplex', 'VisionTek', 'XFX', 'Yeston', 'Zotac',
            ],
            'Teclados' => [
                'Logitech', 'Corsair', 'Razer', 'SteelSeries', 'HyperX (HP)',
                'Cherry', 'Ducky', 'Keychron', 'DROP', 'Filco',
                'Leopold', 'Varmilo', 'Das Keyboard', 'Anne Pro', 'Royal Kludge (RK)',
                'Epomaker', 'Akko', 'Redragon', 'Glorious', 'Wooting',
                'Cooler Master', 'Asus', 'MSI', 'G.Skill', 'Roccat',
                'MonsGeek', 'NuPhy', 'Lofree', 'IQUNIX', 'Yunzii',
                'Motospeed', 'Tecware', 'Ajazz', 'Skyloong', 'MageGee',
            ],
            'Ratones' => [
                'Logitech', 'Razer', 'Corsair', 'SteelSeries', 'HyperX (HP)',
                'Zowie (BenQ)', 'Finalmouse', 'Glorious', 'G-Wolves', 'Pulsar',
                'Cooler Master', 'Asus', 'MSI', 'Cherry', 'Roccat',
                'Mionix', 'Xtrfy', 'Endgame Gear', 'VAXEE', 'Lamzu',
                'Darmoshark', 'Attack Shark', 'Ajazz', 'Delux', 'VGN',
                'Zaopin', 'Sprime', 'Redragon', 'Keychron',
            ],
            'Cables y Accesorios' => [
                'Anker', 'Belkin', 'UGREEN', 'Baseus', 'Cable Matters',
                'Monoprice', 'StarTech', 'JSAUX', 'ATZ', 'Syncwire',
                'iXCC', 'Awei', 'Nomad', 'Native Union', 'Moshi',
                'Elecom', 'Sanwa', 'Kensington', 'Targus', 'BlitzWolf',
                'Essager', 'Samsung', 'Apple', 'Xiaomi', 'Huawei',
                'ORICO', 'Satechi', 'Twelve South', 'Anker (PowerLine)', 'Amazon Basics',
            ],
        ];
    }

    public static function rams()
    {
        return [
            'Celulares' => ['2 GB', '3 GB', '4 GB', '6 GB', '8 GB', '12 GB', '16 GB', '24 GB'],
            'Tablets' => ['2 GB', '3 GB', '4 GB', '6 GB', '8 GB', '12 GB', '16 GB', '24 GB', '32 GB'],
            'Laptop' => ['4 GB', '8 GB', '12 GB', '16 GB', '24 GB', '32 GB', '48 GB', '64 GB', '96 GB', '128 GB'],
            'PC Escritorio' => ['4 GB', '8 GB', '12 GB', '16 GB', '24 GB', '32 GB', '48 GB', '64 GB', '96 GB', '128 GB', '256 GB'],
            'Smartwatches' => ['512 MB', '1 GB', '2 GB', '3 GB', '4 GB', '6 GB', '8 GB'],
            'Memorias RAM' => [
                '4 GB DDR3', '8 GB DDR3', '16 GB DDR3', '32 GB DDR3',
                '4 GB DDR4', '8 GB DDR4', '16 GB DDR4', '32 GB DDR4', '64 GB DDR4',
                '8 GB DDR5', '16 GB DDR5', '32 GB DDR5', '48 GB DDR5', '64 GB DDR5', '96 GB DDR5', '128 GB DDR5',
                '8 GB LPDDR4', '16 GB LPDDR4', '32 GB LPDDR4',
                '8 GB LPDDR5', '16 GB LPDDR5', '32 GB LPDDR5', '64 GB LPDDR5',
                '16 GB LPDDR5X', '24 GB LPDDR5X', '32 GB LPDDR5X',
            ],
            'Tarjetas Gráficas' => [
                '2 GB GDDR5', '4 GB GDDR5', '6 GB GDDR5', '8 GB GDDR5',
                '4 GB GDDR6', '6 GB GDDR6', '8 GB GDDR6', '10 GB GDDR6', '12 GB GDDR6',
                '16 GB GDDR6', '20 GB GDDR6', '24 GB GDDR6',
                '8 GB GDDR6X', '12 GB GDDR6X', '16 GB GDDR6X', '24 GB GDDR6X',
                '4 GB GDDR3', '8 GB HBM2', '16 GB HBM2', '32 GB HBM2', '64 GB HBM2',
            ],
        ];
    }

    public static function almacenamientos()
    {
        return [
            'Celulares' => ['16 GB', '32 GB', '64 GB', '128 GB', '256 GB', '512 GB', '1 TB'],
            'Tablets' => ['16 GB', '32 GB', '64 GB', '128 GB', '256 GB', '512 GB', '1 TB', '2 TB'],
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
    }

    public static function fieldConfigs()
    {
        return [
            'Celulares' => ['color', 'ram', 'almacenamiento'],
            'Laptop' => ['ram', 'almacenamiento', 'procesador', 'tarjeta_grafica'],
            'Tablets' => ['color', 'ram', 'almacenamiento'],
            'PC Escritorio' => ['ram', 'almacenamiento', 'procesador', 'tarjeta_grafica'],
            'Monitores' => ['color'],
            'Televisores' => ['color'],
            'Smartwatches' => ['color', 'ram', 'almacenamiento'],
            'Audífonos' => ['color'],
            'Parlantes y Equipos de Sonido' => ['color'],
            'Radios' => ['color'],
            'Memorias RAM' => ['ram'],
            'Discos SSD' => ['almacenamiento'],
            'Discos HDD' => ['almacenamiento'],
            'Tarjetas Gráficas' => ['ram'],
            'Teclados' => ['color'],
            'Ratones' => ['color'],
            'Cables y Accesorios' => ['color'],
        ];
    }
}
