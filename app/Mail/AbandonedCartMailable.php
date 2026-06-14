<?php

namespace App\Mail;

use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbandonedCartMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $usuario;
    public $items;

    public function __construct(Usuario $usuario, array $items)
    {
        $this->usuario = $usuario;
        $this->items = $items;
    }

    public function build()
    {
        $itemsHtml = '';
        $total = 0;
        foreach ($this->items as $item) {
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
            $itemsHtml .= '<tr><td style="padding:8px;border-bottom:1px solid #f3f4f6">' . htmlspecialchars($item['nombre']) . '</td><td style="padding:8px;text-align:center;border-bottom:1px solid #f3f4f6">' . $item['cantidad'] . '</td><td style="padding:8px;text-align:right;border-bottom:1px solid #f3f4f6">$' . number_format($subtotal, 0, ',', '.') . '</td></tr>';
        }

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('¡Tu carrito te espera! - NeusPhone')
            ->html(
                '<!DOCTYPE html>
<html><head><meta charset="utf-8"></head>
<body style="font-family:Arial,sans-serif;background:#f5f5f5;padding:20px">
<div style="max-width:600px;margin:0 auto;background:white;border-radius:12px;overflow:hidden">
<div style="background:#004080;padding:20px;text-align:center">
<h1 style="color:white;margin:0;font-size:22px">¡No olvides tu carrito!</h1>
</div>
<div style="padding:30px">
<h2 style="color:#333;margin-top:0">Hola ' . htmlspecialchars($this->usuario->nombres) . ',</h2>
<p style="color:#555;line-height:1.6">Vimos que dejaste algunos productos en tu carrito. ¡Aún están disponibles!</p>
<table style="width:100%;border-collapse:collapse;margin:20px 0">
<tr style="background:#f3f4f6"><th style="padding:8px;text-align:left">Producto</th><th style="padding:8px;text-align:center">Cant.</th><th style="padding:8px;text-align:right">Subtotal</th></tr>
' . $itemsHtml . '
<tr><td colspan="2" style="padding:8px;text-align:right;font-weight:bold">Total:</td><td style="padding:8px;text-align:right;font-weight:bold;color:#16a34a">$' . number_format($total, 0, ',', '.') . '</td></tr>
</table>
<div style="text-align:center;margin-top:20px">
<a href="' . route('carrito.index') . '" style="background:#004080;color:white;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:bold;display:inline-block">Ir al carrito</a>
</div>
</div>
<div style="background:#f9fafb;padding:16px 28px;text-align:center;color:#9ca3af;font-size:12px">&copy; ' . date('Y') . ' NeusPhone</div>
</div>
</body></html>'
            );
    }
}
