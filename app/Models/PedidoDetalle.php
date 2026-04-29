<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    protected $table = 'pedido_detalles';

    protected $fillable = [
    'pedido_id',
    'producto_id',
    'cantidad',
    'precio'
];

public function producto()
{
    return $this->belongsTo(\App\Models\Producto::class, 'producto_id');
}
}
