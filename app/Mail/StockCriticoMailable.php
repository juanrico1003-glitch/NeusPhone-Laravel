<?php

namespace App\Mail;

use App\Models\Producto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class StockCriticoMailable extends Mailable
{
    use Queueable;

    public Producto $producto;

    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Stock crítico: ' . $this->producto->nombre . ' - NeusPhone',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.stock-critico',
        );
    }
}
