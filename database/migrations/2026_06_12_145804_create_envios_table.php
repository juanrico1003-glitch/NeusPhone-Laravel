<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Crear la tabla envios
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->string('nombre_contacto');
            $table->string('correo_contacto');
            $table->string('cedula_contacto');
            $table->string('telefono_contacto');
            $table->string('departamento');
            $table->string('municipio');
            $table->string('direccion');
            $table->string('tipo_lugar'); // casa, apartamento, oficina_empresa, edificio, otro
            $table->string('nombre_lugar')->nullable(); // apto, torre, empresa, etc.
            $table->string('detalles_envio')->nullable();
            $table->timestamps();
        });

        // 2. Copiar datos de envío existentes de 'pedidos' a 'envios'
        $pedidos = DB::table('pedidos')->get();
        foreach ($pedidos as $pedido) {
            if (!empty($pedido->direccion)) {
                DB::table('envios')->insert([
                    'pedido_id' => $pedido->id,
                    'nombre_contacto' => $pedido->nombre_contacto ?? '',
                    'correo_contacto' => $pedido->correo_contacto ?? '',
                    'cedula_contacto' => $pedido->cedula_contacto ?? '',
                    'telefono_contacto' => $pedido->telefono_contacto ?? '',
                    'departamento' => $pedido->departamento ?? '',
                    'municipio' => $pedido->municipio ?? '',
                    'direccion' => $pedido->direccion ?? '',
                    'tipo_lugar' => 'casa', // valor por defecto para pedidos antiguos
                    'nombre_lugar' => null,
                    'detalles_envio' => $pedido->detalles_envio ?? null,
                    'created_at' => $pedido->created_at ?? now(),
                    'updated_at' => $pedido->updated_at ?? now(),
                ]);
            }
        }

        // 3. Eliminar columnas de envío de 'pedidos'
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
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Volver a agregar columnas de envío a 'pedidos'
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('nombre_contacto')->nullable()->after('usuario_id');
            $table->string('correo_contacto')->nullable()->after('nombre_contacto');
            $table->string('cedula_contacto')->nullable()->after('correo_contacto');
            $table->string('telefono_contacto')->nullable()->after('cedula_contacto');
            $table->string('departamento')->nullable()->after('telefono_contacto');
            $table->string('municipio')->nullable()->after('departamento');
            $table->string('direccion')->nullable()->after('municipio');
            $table->string('detalles_envio')->nullable()->after('direccion');
        });

        // 2. Copiar los datos de vuelta de 'envios' a 'pedidos'
        $envios = DB::table('envios')->get();
        foreach ($envios as $envio) {
            DB::table('pedidos')
                ->where('id', $envio->pedido_id)
                ->update([
                    'nombre_contacto' => $envio->nombre_contacto,
                    'correo_contacto' => $envio->correo_contacto,
                    'cedula_contacto' => $envio->cedula_contacto,
                    'telefono_contacto' => $envio->telefono_contacto,
                    'departamento' => $envio->departamento,
                    'municipio' => $envio->municipio,
                    'direccion' => $envio->direccion,
                    'detalles_envio' => $envio->detalles_envio,
                ]);
        }

        // 3. Eliminar la tabla 'envios'
        Schema::dropIfExists('envios');
    }
};
