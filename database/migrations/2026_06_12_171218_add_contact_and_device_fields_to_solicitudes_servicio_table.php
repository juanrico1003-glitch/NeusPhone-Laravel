<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solicitudes_servicio', function (Blueprint $table) {
            $table->string('telefono', 20)->nullable()->after('descripcion_problema');
            $table->string('email_contacto', 150)->nullable()->after('telefono');
            $table->text('direccion')->nullable()->after('email_contacto');
            $table->string('tipo_equipo', 100)->nullable()->after('direccion');
            $table->string('marca_equipo', 100)->nullable()->after('tipo_equipo');
            $table->string('modelo_equipo', 100)->nullable()->after('marca_equipo');
            $table->string('numero_serie', 100)->nullable()->after('modelo_equipo');
            $table->text('accesorios_incluidos')->nullable()->after('numero_serie');
        });
    }

    public function down(): void
    {
        Schema::table('solicitudes_servicio', function (Blueprint $table) {
            $table->dropColumn([
                'telefono',
                'email_contacto',
                'direccion',
                'tipo_equipo',
                'marca_equipo',
                'modelo_equipo',
                'numero_serie',
                'accesorios_incluidos',
            ]);
        });
    }
};
