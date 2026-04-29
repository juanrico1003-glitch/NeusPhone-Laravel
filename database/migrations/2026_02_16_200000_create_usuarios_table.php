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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rol_id')->default(2)->constrained('roles');
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('cedula', 20)->nullable()->unique();
            $table->string('correo', 150)->nullable()->unique();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('password');
            $table->tinyInteger('estado')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};