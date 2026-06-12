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
        'telefono',
        'email_contacto',
        'direccion',
        'tipo_equipo',
        'marca_equipo',
        'modelo_equipo',
        'numero_serie',
        'accesorios_incluidos',
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
