<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variantes_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->string('color')->nullable();
            $table->string('ram')->nullable();
            $table->string('almacenamiento')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->decimal('precio_adicional', 12, 0)->default(0);
            $table->integer('stock')->default(0);
            $table->string('imagen')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variantes_producto');
    }
};
