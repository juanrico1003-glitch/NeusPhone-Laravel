<?php

namespace App\Models;

use App\Models\Usuario;
use App\Models\Servicio;
use Illuminate\Database\Eloquent\Model;

class SolicitudServicio extends Model
{
    protected $table = 'solicitudes_servicio';

    protected $fillable = [
    'usuario_id',
    'servicio_id',
    'descripcion_problema',
    'estado'
];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function servicio()
{
    return $this->belongsTo(Servicio::class);
}
}
