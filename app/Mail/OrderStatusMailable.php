<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public Pedido $pedido;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Estado de tu pedido #' . $this->pedido->id . ' - NeusPhone')
            ->view('emails.pedido-estado')
            ->with(['pedido' => $this->pedido]);
    }
}
