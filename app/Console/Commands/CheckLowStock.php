<?php

namespace App\Console\Commands;

use App\Mail\LowStockAlert;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckLowStock extends Command
{
    protected $signature = 'app:check-low-stock';

    protected $description = 'Verifica productos con stock bajo y envía alerta a los administradores';

    public function handle()
    {
        $bajoStock = Producto::where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->get();

        $agotados = Producto::where('stock', '<=', 0)->get();

        if ($bajoStock->isEmpty() && $agotados->isEmpty()) {
            $this->info('No hay productos con stock crítico.');
            return Command::SUCCESS;
        }

        $admins = Usuario::where('rol_id', 1)->whereNull('deleted_at')->get();

        foreach ($admins as $admin) {
            try {
                Mail::to($admin->correo)->send(new LowStockAlert($bajoStock, $agotados));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Error enviando alerta de stock a {$admin->correo}: " . $e->getMessage());
            }
        }

        $this->info("Alerta enviada a " . $admins->count() . " administradores. {$bajoStock->count()} productos con stock bajo, {$agotados->count()} agotados.");

        return Command::SUCCESS;
    }
}
