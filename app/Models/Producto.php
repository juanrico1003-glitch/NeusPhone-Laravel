<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'marca',
        'nombre',
        'tipo',
        'color',
        'ram',
        'almacenamiento',
        'precio',
        'descuento',
        'stock',
        'visitas',
        'descripcion',
        'caracteristicas',
        'imagenes',
        'estado',
        'procesador',
        'tarjeta_grafica'
    ];

    protected $casts = [
        'imagenes' => 'array',
        'descuento' => 'decimal:2'
    ];

    public function getPrecioConDescuentoAttribute()
    {
        if ($this->descuento && $this->descuento > 0) {
            return $this->precio - ($this->precio * $this->descuento / 100);
        }
        return $this->precio;
    }

    public function getTieneDescuentoAttribute()
    {
        return $this->descuento && $this->descuento > 0;
    }

    public function getDescuentoFormateadoAttribute()
    {
        if (!$this->descuento) return '0';
        $partes = explode('.', number_format($this->descuento, 2, '.', ''));
        if (!isset($partes[1]) || $partes[1] === '00') return $partes[0];
        return rtrim(rtrim($partes[0] . '.' . $partes[1], '0'), '.');
    }

public function categoria()
{
    return $this->belongsTo(Categoria::class);
}

public function testimonios()
{
    return $this->hasMany(Testimonio::class);
}

public function fotos()
{
    return $this->hasMany(ProductImage::class)->orderBy('orden');
}

public function variantes()
{
    return $this->hasMany(VarianteProducto::class);
}

}
