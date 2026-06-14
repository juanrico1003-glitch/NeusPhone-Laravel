<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStockSubscription extends Model
{
    protected $fillable = ['producto_id', 'usuario_id', 'email', 'notified_at'];

    protected $casts = ['notified_at' => 'datetime'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
