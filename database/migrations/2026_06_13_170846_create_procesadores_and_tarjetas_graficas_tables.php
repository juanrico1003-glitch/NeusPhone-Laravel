<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procesadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->timestamps();
            $table->unique(['categoria_id', 'nombre']);
        });

        Schema::create('tarjetas_graficas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->timestamps();
            $table->unique(['categoria_id', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarjetas_graficas');
        Schema::dropIfExists('procesadores');
    }
};
