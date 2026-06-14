<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->decimal('subtotal', 12, 2)->nullable()->after('total');
            $table->decimal('descuento', 12, 2)->default(0)->after('subtotal');
            $table->unsignedBigInteger('cupon_id')->nullable()->after('descuento');
            if (Schema::hasTable('cupones')) {
                $table->foreign('cupon_id')->references('id')->on('cupones')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (Schema::hasColumn('pedidos', 'cupon_id')) {
                try {
                    $table->dropForeign(['cupon_id']);
                } catch (\Exception $e) {
                    // ignore if foreign doesn't exist
                }
            }
            $table->dropColumn(['subtotal', 'descuento', 'cupon_id']);
        });
    }
};
