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
        Schema::create('solicitudes_servicio', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('usuario_id')->index('usuario_id');
            $table->integer('servicio_id')->index('servicio_id');
            $table->text('descripcion_problema')->nullable();
            $table->enum('estado', ['pendiente', 'en_revision', 'reparado', 'entregado', 'cancelado'])->nullable()->default('pendiente');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_servicio');
    }
};
