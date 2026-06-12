<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
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
        'stock',
        'visitas',
        'descripcion',
        'caracteristicas',
        'imagenes',
        'estado'
    ];

    protected $casts = [
        'imagenes' => 'array'
    ];

public function categoria()
{
    return $this->belongsTo(Categoria::class);
}

public function testimonios()
{
    return $this->hasMany(Testimonio::class);
}

}
