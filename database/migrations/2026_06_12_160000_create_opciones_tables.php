<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->timestamps();
            $table->unique(['categoria_id', 'nombre']);
        });

        Schema::create('colores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->timestamps();
            $table->unique('nombre');
        });

        Schema::create('rams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->string('nombre', 50);
            $table->timestamps();
            $table->unique(['categoria_id', 'nombre']);
        });

        Schema::create('almacenamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->string('nombre', 50);
            $table->timestamps();
            $table->unique(['categoria_id', 'nombre']);
        });

        Schema::create('category_field_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->string('campo', 50);
            $table->timestamps();
            $table->unique(['categoria_id', 'campo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_field_configs');
        Schema::dropIfExists('almacenamientos');
        Schema::dropIfExists('rams');
        Schema::dropIfExists('colores');
        Schema::dropIfExists('marcas');
    }
};
