<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderAdminMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function build()
    {
        return $this->subject('Nuevo Pedido #' . $this->pedido->id)
                    ->html("
                        <h2>Nuevo Pedido #{$this->pedido->id}</h2>
                        <p><strong>Cliente:</strong> {$this->pedido->usuario?->nombres} {$this->pedido->usuario?->apellidos}</p>
                        <p><strong>Email:</strong> {$this->pedido->usuario?->correo}</p>
                        <p><strong>Total:</strong> \$" . number_format($this->pedido->total, 0, ',', '.') . "</p>
                        <p><strong>Estado:</strong> {$this->pedido->estado}</p>
                        <p><strong>Fecha:</strong> {$this->pedido->created_at}</p>
                        <a href=\"" . route('admin.pedidos.show', $this->pedido->id) . "\" style=\"display:inline-block;padding:10px 20px;background:#004080;color:#fff;text-decoration:none;border-radius:5px;\">Ver Pedido</a>
                    ");
    }
}
