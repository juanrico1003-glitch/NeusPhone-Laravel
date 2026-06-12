<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcasSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
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
            'Portátiles' => [
                'Apple', 'Dell', 'HP', 'Lenovo', 'Asus',
                'Acer', 'MSI', 'Razer', 'Samsung', 'Huawei',
                'Xiaomi', 'Microsoft', 'LG', 'Gigabyte', 'Google',
                'Framework', 'System76', 'Tuxedo', 'Clevo', 'Toshiba',
                'Sony (VAIO)', 'Fujitsu', 'Panasonic', 'Dynabook', 'Chuwi',
                'One Netbook', 'GPD', 'AYANEO',
            ],
            'PC Escritorio' => [
                'Dell', 'HP', 'Lenovo', 'Apple', 'Asus',
                'Acer', 'MSI', 'Corsair', 'CyberPowerPC', 'NZXT',
                'Alienware', 'Origin PC', 'Falcon Northwest', 'Puget Systems', 'Maingear',
                'iBuyPower', 'Skytech', 'CLX', 'Digital Storm', 'Velztorm',
                'Samsung', 'Intel (NUC)', 'Gigabyte', 'Zotac', 'Minisforum',
                'Beelink', 'ASRock', 'Intel', 'AMD',
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
                'Diesel', 'Emporio Armani', 'Citizen',
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
                'Nvidia', 'AMD', 'Asus', 'MSI', 'Gigabyte',
                'Zotac', 'PNY', 'Palit', 'Gainward', 'Sapphire',
                'PowerColor', 'XFX', 'ASRock', 'Colorful', 'Galax',
                'Inno3D', 'Manli', 'AFOX', 'Leadtek', 'EVGA',
                'VisionTek', 'Diamond', 'HIS', 'Club 3D', 'Maxsun',
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

        foreach ($marcas as $categoriaNombre => $brands) {
            $catId = DB::table('categorias')->where('nombre', $categoriaNombre)->value('id');
            if (!$catId) continue;

            foreach ($brands as $brand) {
                DB::table('marcas')->insertOrIgnore([
                    'categoria_id' => $catId,
                    'nombre' => $brand,
                ]);
            }
        }
    }
}
