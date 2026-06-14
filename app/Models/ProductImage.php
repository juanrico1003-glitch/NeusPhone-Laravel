<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'producto_imagenes';

    protected $fillable = ['producto_id', 'ruta', 'orden'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
