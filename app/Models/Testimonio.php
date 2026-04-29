<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonio extends Model
{
    protected $table = 'testimonios';

    protected $fillable = [
        'usuario_id',
        'comentario',
        'calificacion',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
