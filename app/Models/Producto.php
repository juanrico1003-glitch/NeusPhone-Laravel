<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Color;
use App\Models\Almacenamiento;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'marca_id',
        'nombre',
        'tipo',
        'color_id',
        'almacenamiento_id',
        'precio',
        'stock',
        'descripcion',
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

public function marca()
{
    return $this->belongsTo(Marca::class);
}

public function color()
{
    return $this->belongsTo(Color::class);
}

public function almacenamiento()
{
    return $this->belongsTo(Almacenamiento::class);
}

}
