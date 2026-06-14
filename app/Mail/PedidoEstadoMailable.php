<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoEstadoMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Pedido $pedido;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Estado de tu pedido #' . $this->pedido->id . ' - NeusPhone',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pedido-estado',
        );
    }
}
