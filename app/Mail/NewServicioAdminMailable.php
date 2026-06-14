<?php

namespace App\Mail;

use App\Models\SolicitudServicio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewServicioAdminMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $servicio;

    public function __construct(SolicitudServicio $servicio)
    {
        $this->servicio = $servicio;
    }

    public function build()
    {
        return $this->subject('Nuevo Servicio Técnico #' . $this->servicio->id)
                    ->html("
                        <h2>Nuevo Servicio Técnico #{$this->servicio->id}</h2>
                        <p><strong>Cliente:</strong> {$this->servicio->usuario?->nombres} {$this->servicio->usuario?->apellidos}</p>
                        <p><strong>Email:</strong> {$this->servicio->usuario?->correo}</p>
                        <p><strong>Descripción:</strong> {$this->servicio->descripcion}</p>
                        <p><strong>Tipo:</strong> {$this->servicio->tipo}</p>
                        <p><strong>Fecha:</strong> {$this->servicio->created_at}</p>
                    ");
    }
}
