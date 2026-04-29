<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'usuario_id',
        'tipo_equipo',
        'marca',
        'modelo',
        'descripcion_problema',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
