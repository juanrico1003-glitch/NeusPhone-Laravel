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
        if (!Schema::hasTable('carrito')) {
            Schema::create('carrito', function (Blueprint $table) {
                $table->id();
                $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
                $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
                $table->integer('cantidad')->default(1);
                $table->timestamps();
                $table->unique(['usuario_id', 'producto_id']);
            });
        }

        if (!Schema::hasTable('favoritos')) {
            Schema::create('favoritos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
                $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
                $table->timestamps();
                $table->unique(['usuario_id', 'producto_id']);
            });
        }

        if (!Schema::hasColumn('envios', 'numero_guia')) {
            Schema::table('envios', function (Blueprint $table) {
                $table->string('numero_guia', 100)->nullable()->after('detalles_envio');
            });
        }

        if (!Schema::hasColumn('categorias', 'imagen')) {
            Schema::table('categorias', function (Blueprint $table) {
                $table->string('imagen', 255)->nullable()->after('nombre');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('carrito');
        Schema::dropIfExists('favoritos');
        Schema::table('envios', function (Blueprint $table) {
            $table->dropColumn('numero_guia');
        });
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropColumn('imagen');
        });
    }
};
