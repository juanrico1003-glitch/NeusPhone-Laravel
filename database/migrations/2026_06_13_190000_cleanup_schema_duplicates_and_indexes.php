<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->removeDuplicateOptions('marcas', 'nombre');
        $this->removeDuplicateOptions('rams', 'nombre');
        $this->removeDuplicateOptions('almacenamientos', 'nombre');
        $this->removeDuplicateOptions('procesadores', 'nombre');
        $this->removeDuplicateOptions('tarjetas_graficas', 'nombre');
        $this->removeDuplicateOptions('category_field_configs', 'campo');
        $this->removeDuplicateSubscriptions();

        $this->addUniqueIfMissing('marcas', 'marcas_categoria_id_nombre_unique', ['categoria_id', 'nombre']);
        $this->addUniqueIfMissing('rams', 'rams_categoria_id_nombre_unique', ['categoria_id', 'nombre']);
        $this->addUniqueIfMissing('almacenamientos', 'almacenamientos_categoria_id_nombre_unique', ['categoria_id', 'nombre']);
        $this->addUniqueIfMissing('procesadores', 'procesadores_categoria_id_nombre_unique', ['categoria_id', 'nombre']);
        $this->addUniqueIfMissing('tarjetas_graficas', 'tarjetas_graficas_categoria_id_nombre_unique', ['categoria_id', 'nombre']);
        $this->addUniqueIfMissing('category_field_configs', 'category_field_configs_categoria_id_campo_unique', ['categoria_id', 'campo']);
        $this->addUniqueIfMissing('product_stock_subscriptions', 'product_stock_subscriptions_producto_id_email_unique', ['producto_id', 'email']);

        Schema::dropIfExists('solicitud_servicios');
    }

    public function down(): void
    {
        $this->dropIndexIfExists('product_stock_subscriptions', 'product_stock_subscriptions_producto_id_email_unique');
        $this->dropIndexIfExists('category_field_configs', 'category_field_configs_categoria_id_campo_unique');
        $this->dropIndexIfExists('tarjetas_graficas', 'tarjetas_graficas_categoria_id_nombre_unique');
        $this->dropIndexIfExists('procesadores', 'procesadores_categoria_id_nombre_unique');
        $this->dropIndexIfExists('almacenamientos', 'almacenamientos_categoria_id_nombre_unique');
        $this->dropIndexIfExists('rams', 'rams_categoria_id_nombre_unique');
        $this->dropIndexIfExists('marcas', 'marcas_categoria_id_nombre_unique');
    }

    private function removeDuplicateOptions(string $table, string $valueColumn): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        DB::table($table)
            ->select('categoria_id', $valueColumn, DB::raw('MIN(id) as keep_id'), DB::raw('COUNT(*) as total'))
            ->groupBy('categoria_id', $valueColumn)
            ->having('total', '>', 1)
            ->orderBy('keep_id')
            ->each(function ($duplicate) use ($table, $valueColumn) {
                DB::table($table)
                    ->where('categoria_id', $duplicate->categoria_id)
                    ->where($valueColumn, $duplicate->{$valueColumn})
                    ->where('id', '!=', $duplicate->keep_id)
                    ->delete();
            });
    }

    private function removeDuplicateSubscriptions(): void
    {
        if (!Schema::hasTable('product_stock_subscriptions')) {
            return;
        }

        DB::table('product_stock_subscriptions')
            ->select('producto_id', 'email', DB::raw('MIN(id) as keep_id'), DB::raw('COUNT(*) as total'))
            ->groupBy('producto_id', 'email')
            ->having('total', '>', 1)
            ->orderBy('keep_id')
            ->each(function ($duplicate) {
                DB::table('product_stock_subscriptions')
                    ->where('producto_id', $duplicate->producto_id)
                    ->where('email', $duplicate->email)
                    ->where('id', '!=', $duplicate->keep_id)
                    ->delete();
            });
    }

    private function addUniqueIfMissing(string $table, string $index, array $columns): void
    {
        if (!Schema::hasTable($table) || $this->hasIndex($table, $index)) {
            return;
        }

        Schema::table($table, function (Blueprint $table) use ($columns, $index) {
            $table->unique($columns, $index);
        });
    }

    private function dropIndexIfExists(string $table, string $index): void
    {
        if (!Schema::hasTable($table) || !$this->hasIndex($table, $index)) {
            return;
        }

        Schema::table($table, function (Blueprint $table) use ($index) {
            $table->dropUnique($index);
        });
    }

    private function hasIndex(string $table, string $index): bool
    {
        if (DB::getDriverName() === 'sqlite') {
            return collect(DB::select("PRAGMA index_list('{$table}')"))
                ->contains(fn($item) => $item->name === $index);
        }

        return collect(DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$index]))->isNotEmpty();
    }
};
