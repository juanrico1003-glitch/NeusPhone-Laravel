<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Almacenamiento extends Model
{
    protected $table = 'almacenamientos';

    protected $fillable = [
        'capacidad'
    ];
}
