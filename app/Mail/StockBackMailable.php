<?php

namespace App\Mail;

use App\Models\Producto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockBackMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $producto;
    public $email;

    public function __construct(Producto $producto, string $email)
    {
        $this->producto = $producto;
        $this->email = $email;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('¡El producto ' . $this->producto->nombre . ' ya está disponible! - NeusPhone')
            ->html(
                '<!DOCTYPE html>
<html><head><meta charset="utf-8"></head>
<body style="font-family:Arial,sans-serif;background:#f5f5f5;padding:20px">
<div style="max-width:600px;margin:0 auto;background:white;border-radius:12px;overflow:hidden">
<div style="background:#004080;padding:20px;text-align:center">
<h1 style="color:white;margin:0;font-size:22px">¡Producto disponible!</h1>
</div>
<div style="padding:30px">
<h2 style="color:#333;margin-top:0">' . htmlspecialchars($this->producto->nombre) . '</h2>
<p style="color:#555;line-height:1.6">El producto que estabas esperando ya tiene stock disponible.</p>
<div style="text-align:center;margin:20px 0">
<img src="' . asset('productos/' . (!empty($this->producto->imagenes) ? $this->producto->imagenes[0] : 'default.png')) . '" alt="' . htmlspecialchars($this->producto->nombre) . '" style="max-width:200px;max-height:200px;object-contain;border-radius:8px">
</div>
<p style="text-align:center;font-size:24px;font-weight:bold;color:#16a34a">$' . number_format($this->producto->precio_con_descuento, 0, ',', '.') . '</p>
<div style="text-align:center;margin-top:20px">
<a href="' . route('tienda.producto', $this->producto->id) . '" style="background:#004080;color:white;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:bold;display:inline-block">Ver producto</a>
</div>
</div>
<div style="background:#f9fafb;padding:16px 28px;text-align:center;color:#9ca3af;font-size:12px">&copy; ' . date('Y') . ' NeusPhone &mdash; Recibes este correo porque te suscribiste para recibir notificaciones de disponibilidad.</div>
</div>
</body></html>'
            );
    }
}
