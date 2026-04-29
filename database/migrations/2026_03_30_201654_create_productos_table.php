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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('marca_id')->constrained('marcas');
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 12, 2);
            $table->integer('stock')->default(0);
            $table->enum('tipo', ['nuevo', 'usado']);
            $table->tinyInteger('estado')->default(1);
            $table->string('imagen')->nullable();
            $table->foreignId('color_id')->nullable()->constrained('colores');
            $table->foreignId('almacenamiento_id')->nullable()->constrained('almacenamientos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};