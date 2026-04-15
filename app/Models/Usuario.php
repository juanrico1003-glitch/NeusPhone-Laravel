<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'rol_id',
        'nombres',
        'apellidos',
        'cedula',
        'correo',
        'fecha_nacimiento',
        'password',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
    public function servicios()
{
    return $this->hasMany(Servicio::class, 'usuario_id');
}
public function solicitudesServicio()
{
    return $this->hasMany(SolicitudServicio::class, 'usuario_id');
}
}
