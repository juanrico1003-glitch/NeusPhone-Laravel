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
    Schema::create('solicitud_servicios', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
        $table->string('tipo_equipo');
        $table->string('marca')->nullable();
        $table->string('modelo')->nullable();
        $table->text('descripcion_problema');
        $table->enum('estado', [
            'pendiente',
            'en_revision',
            'reparado',
            'entregado',
            'cancelado'
        ])->default('pendiente');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_servicios');
    }
};
