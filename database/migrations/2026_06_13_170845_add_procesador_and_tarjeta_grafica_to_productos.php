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
        Schema::table('productos', function (Blueprint $table) {
            $table->string('procesador', 100)->nullable()->after('almacenamiento');
            $table->string('tarjeta_grafica', 100)->nullable()->after('procesador');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['procesador', 'tarjeta_grafica']);
        });
    }
};
