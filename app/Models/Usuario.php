<?php

namespace App\Models;

use App\Notifications\PasswordResetNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'rol_id',
        'nombres',
        'apellidos',
        'cedula',
        'telefono',
        'correo',
        'google_id',
        'avatar',
        'fecha_nacimiento',
        'password',
        'estado',
        'deleted_at',
        'deleted_scheduled_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'deleted_scheduled_at' => 'datetime',
    ];

    public function getEmailForPasswordReset(): string
    {
        return $this->correo;
    }

    public function sendPasswordResetNotification($token): void
    {
        $url = route('password.reset', ['token' => $token, 'correo' => $this->correo]);

        try {
            \Illuminate\Support\Facades\Mail::mailer('smtp')->send(
                (new \App\Mail\PasswordResetMailable($url, $this->nombres ?? ''))
                    ->to($this->correo)
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Password reset mail failed: ' . $e->getMessage());
        }
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
        public function scopeActivos($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function estaEliminado(): bool
    {
        return !is_null($this->deleted_at);
    }

    public function puedeRecuperarse(): bool
    {
        return $this->estaEliminado() && $this->deleted_scheduled_at?->isFuture();
    }

    public function recuperar(): void
    {
        $this->update(['deleted_at' => null, 'deleted_scheduled_at' => null]);
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
