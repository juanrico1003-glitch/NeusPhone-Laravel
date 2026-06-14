<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VarianteProducto extends Model
{
    protected $table = 'variantes_producto';

    protected $fillable = [
        'producto_id', 'color', 'ram', 'almacenamiento',
        'sku', 'precio_adicional', 'stock', 'imagen'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
