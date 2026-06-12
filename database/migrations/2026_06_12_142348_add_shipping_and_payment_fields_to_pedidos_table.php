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
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('nombre_contacto')->after('usuario_id');
            $table->string('correo_contacto')->after('nombre_contacto');
            $table->string('cedula_contacto')->after('correo_contacto');
            $table->string('telefono_contacto')->after('cedula_contacto');
            
            $table->string('departamento')->after('telefono_contacto');
            $table->string('municipio')->after('departamento');
            $table->string('direccion')->after('municipio');
            $table->string('detalles_envio')->nullable()->after('direccion');
            
            $table->string('wompi_reference')->nullable()->after('estado');
            $table->string('wompi_transaction_id')->nullable()->after('wompi_reference');
            $table->string('wompi_payment_method')->nullable()->after('wompi_transaction_id');
            $table->string('wompi_status')->nullable()->after('wompi_payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'nombre_contacto',
                'correo_contacto',
                'cedula_contacto',
                'telefono_contacto',
                'departamento',
                'municipio',
                'direccion',
                'detalles_envio',
                'wompi_reference',
                'wompi_transaction_id',
                'wompi_payment_method',
                'wompi_status'
            ]);
        });
    }
};
