<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $table = 'envios';

    protected $fillable = [
        'pedido_id',
        'nombre_contacto',
        'correo_contacto',
        'cedula_contacto',
        'telefono_contacto',
        'departamento',
        'municipio',
        'direccion',
        'tipo_lugar',
        'nombre_lugar',
        'detalles_envio',
        'numero_guia'
    ];

    public function pedido()
    {
        return $this->belongsTo(\App\Models\Pedido::class, 'pedido_id');
    }
}
