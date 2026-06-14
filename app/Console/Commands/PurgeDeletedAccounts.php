<?php

namespace App\Console\Commands;

use App\Models\Usuario;
use Illuminate\Console\Command;

class PurgeDeletedAccounts extends Command
{
    protected $signature = 'app:purge-deleted-accounts';

    protected $description = 'Elimina permanentemente cuentas cuya fecha de eliminación programada ya venció';

    public function handle()
    {
        $vencidos = Usuario::whereNotNull('deleted_at')
            ->where('deleted_scheduled_at', '<=', now())
            ->get();

        $count = $vencidos->count();

        foreach ($vencidos as $usuario) {
            $usuario->delete();
        }

        $this->info("Se eliminaron permanentemente {$count} cuentas.");

        return Command::SUCCESS;
    }
}
