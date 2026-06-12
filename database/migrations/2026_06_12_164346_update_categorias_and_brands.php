<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Rename "PC" → "Laptop" (safe: no-op if "PC" doesn't exist)
        DB::table('categorias')->where('nombre', 'PC')->update(['nombre' => 'Laptop']);

        // Rename "PCs de Escritorio" → "PC Escritorio" (safe: no-op if doesn't exist)
        DB::table('categorias')->where('nombre', 'PCs de Escritorio')->update(['nombre' => 'PC Escritorio']);

        // Add comprehensive laptop brands to "Laptop" category — resolve id by name
        $laptopId = DB::table('categorias')->where('nombre', 'Laptop')->value('id');
        if ($laptopId) {
            $existingLaptop = DB::table('marcas')->where('categoria_id', $laptopId)->pluck('nombre')->toArray();
            $newLaptopBrands = array_diff([
                'Acer', 'Alienware', 'Apple', 'AORUS', 'ASRock', 'Asus',
                'Avita', 'Clevo', 'Chuwi', 'Corsair', 'CyberPowerPC', 'Dell',
                'Dynabook', 'Fujitsu', 'Framework', 'Gigabyte', 'Google', 'GPD',
                'Hasee', 'Honor', 'HP', 'Huawei', 'Intel', 'Jumper',
                'LG', 'Lenovo', 'Maingear', 'Medion', 'Microsoft', 'Minisforum',
                'MSI', 'NZXT', 'One Netbook', 'Origin PC', 'Panasonic', 'Razer',
                'Samsung', 'Schenker', 'System76', 'Toshiba', 'Tuxedo', 'VAIO',
                'Velocity Micro', 'Xiaomi', 'XMG', 'Zotac',
            ], $existingLaptop);

            foreach ($newLaptopBrands as $brand) {
                DB::table('marcas')->insert([
                    'categoria_id' => $laptopId,
                    'nombre' => $brand,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Add more brands to "Portátiles"
        $portatilesId = DB::table('categorias')->where('nombre', 'Portátiles')->value('id');
        if ($portatilesId) {
            $existingPortatiles = DB::table('marcas')->where('categoria_id', $portatilesId)->pluck('nombre')->toArray();
            $newPortatilesBrands = array_diff([
                'Acer', 'Alienware', 'Apple', 'AORUS', 'ASRock', 'Asus',
                'Avita', 'Clevo', 'Chuwi', 'Corsair', 'CyberPowerPC', 'Dell',
                'Dynabook', 'Fujitsu', 'Framework', 'Gigabyte', 'Google', 'GPD',
                'Hasee', 'Honor', 'HP', 'Huawei', 'Intel', 'Jumper',
                'LG', 'Lenovo', 'Maingear', 'Medion', 'Microsoft', 'Minisforum',
                'MSI', 'NZXT', 'One Netbook', 'Origin PC', 'Panasonic', 'Razer',
                'Samsung', 'Schenker', 'System76', 'Toshiba', 'Tuxedo', 'VAIO',
                'Velocity Micro', 'Xiaomi', 'XMG', 'Zotac',
            ], $existingPortatiles);

            foreach ($newPortatilesBrands as $brand) {
                DB::table('marcas')->insert([
                    'categoria_id' => $portatilesId,
                    'nombre' => $brand,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Add comprehensive brands to "PC Escritorio"
        $escritorioId = DB::table('categorias')->where('nombre', 'PC Escritorio')->value('id');
        if ($escritorioId) {
            $existingEscritorio = DB::table('marcas')->where('categoria_id', $escritorioId)->pluck('nombre')->toArray();
            $newEscritorioBrands = array_diff([
                'Acer', 'Alienware', 'Apple', 'ASRock', 'Asus', 'Azulle',
                'Beelink', 'CLX', 'Cooler Master', 'Corsair', 'CyberPowerPC', 'Dell',
                'Digital Storm', 'Falcon Northwest', 'Gigabyte', 'HP', 'iBuyPower',
                'Intel', 'Lenovo', 'Maingear', 'Minisforum', 'MSI', 'NZXT',
                'Origin PC', 'Puget Systems', 'Samsung', 'Shuttle', 'Skytech',
                'Thermaltake', 'Velztorm', 'Zotac',
            ], $existingEscritorio);

            foreach ($newEscritorioBrands as $brand) {
                DB::table('marcas')->insert([
                    'categoria_id' => $escritorioId,
                    'nombre' => $brand,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Add more brands to "Tarjetas Gráficas"
        $gpuId = DB::table('categorias')->where('nombre', 'Tarjetas Gráficas')->value('id');
        if ($gpuId) {
            $existingGpu = DB::table('marcas')->where('categoria_id', $gpuId)->pluck('nombre')->toArray();
            $newGpuBrands = array_diff([
                'AMD', 'AFOX', 'ASRock', 'Asus', 'BIOSTAR', 'Club 3D', 'Colorful',
                'Diamond', 'ELSA', 'EVGA', 'Gainward', 'Galax', 'Gigabyte',
                'HIS', 'Inno3D', 'Leadtek', 'Manli', 'Maxsun', 'MSI',
                'Nvidia', 'Palit', 'PNY', 'PowerColor', 'Sapphire', 'Sparkle',
                'Triplex', 'VisionTek', 'XFX', 'Yeston', 'Zotac',
            ], $existingGpu);

            foreach ($newGpuBrands as $brand) {
                DB::table('marcas')->insert([
                    'categoria_id' => $gpuId,
                    'nombre' => $brand,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('categorias')->where('nombre', 'Laptop')->update(['nombre' => 'PC']);
        DB::table('categorias')->where('nombre', 'PC Escritorio')->update(['nombre' => 'PCs de Escritorio']);

        $laptopId = DB::table('categorias')->where('nombre', 'PC')->value('id');
        if ($laptopId) {
            DB::table('marcas')->where('categoria_id', $laptopId)->whereIn('nombre', [
                'AORUS', 'ASRock', 'Avita', 'Clevo', 'Corsair', 'CyberPowerPC',
                'GPD', 'Hasee', 'Intel', 'Jumper', 'Maingear', 'Medion',
                'Minisforum', 'NZXT', 'Origin PC', 'Schenker', 'System76',
                'Tuxedo', 'VAIO', 'Velocity Micro', 'XMG', 'Zotac',
            ])->delete();
        }

        $portatilesId = DB::table('categorias')->where('nombre', 'Portátiles')->value('id');
        if ($portatilesId) {
            DB::table('marcas')->where('categoria_id', $portatilesId)->whereIn('nombre', [
                'AORUS', 'ASRock', 'Avita', 'Clevo', 'Corsair', 'CyberPowerPC',
                'GPD', 'Hasee', 'Intel', 'Jumper', 'Maingear', 'Medion',
                'Minisforum', 'NZXT', 'Origin PC', 'Schenker', 'System76',
                'Tuxedo', 'VAIO', 'Velocity Micro', 'XMG', 'Zotac',
            ])->delete();
        }

        $escritorioId = DB::table('categorias')->where('nombre', 'PCs de Escritorio')->value('id');
        if ($escritorioId) {
            DB::table('marcas')->where('categoria_id', $escritorioId)->whereIn('nombre', [
                'Azulle', 'Beelink', 'CLX', 'Cooler Master', 'CyberPowerPC',
                'Digital Storm', 'Falcon Northwest', 'iBuyPower', 'Intel',
                'Maingear', 'Minisforum', 'NZXT', 'Origin PC', 'Puget Systems',
                'Shuttle', 'Skytech', 'Thermaltake', 'Velztorm', 'Zotac',
            ])->delete();
        }

        $gpuId = DB::table('categorias')->where('nombre', 'Tarjetas Gráficas')->value('id');
        if ($gpuId) {
            DB::table('marcas')->where('categoria_id', $gpuId)->whereIn('nombre', [
                'BIOSTAR', 'ELSA', 'Sparkle', 'Triplex', 'Yeston',
            ])->delete();
        }
    }
};
