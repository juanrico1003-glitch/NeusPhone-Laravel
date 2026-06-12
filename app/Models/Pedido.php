<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'usuario_id',
        'total',
        'estado',
        'wompi_reference',
        'wompi_transaction_id',
        'wompi_payment_method',
        'wompi_status'
    ];

    public function detalles()
    {
        return $this->hasMany(\App\Models\PedidoDetalle::class, 'pedido_id');
    }

    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'usuario_id');
    }

    public function envio()
    {
        return $this->hasOne(\App\Models\Envio::class, 'pedido_id');
    }
}
