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
            $table->string('marca', 100);
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 12, 2);
            $table->integer('stock')->default(0);
            $table->enum('tipo', ['nuevo', 'usado']);
            $table->tinyInteger('estado')->default(1);
            $table->string('imagen')->nullable();
            $table->string('color', 50)->nullable();
            $table->string('almacenamiento', 50)->nullable();
            $table->string('ram', 50)->nullable();
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