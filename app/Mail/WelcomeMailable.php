<?php

namespace App\Mail;

use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public Usuario $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Bienvenido a NeusPhone')
            ->html(
                '<!DOCTYPE html>
<html><head><meta charset="utf-8"></head>
<body style="font-family:Arial,sans-serif;background:#f5f5f5;padding:20px">
<div style="max-width:600px;margin:0 auto;background:white;border-radius:12px;overflow:hidden">
<div style="background:#2563eb;padding:20px;text-align:center">
<h1 style="color:white;margin:0;font-size:22px">NeusPhone</h1>
</div>
<div style="padding:30px">
<h2 style="color:#333;margin-top:0">¡Bienvenido, ' . htmlspecialchars($this->usuario->nombres) . '!</h2>
<p style="color:#555;line-height:1.6">Gracias por registrarte en NeusPhone. Ya puedes explorar nuestro catálogo de productos y realizar tus compras.</p>
<div style="text-align:center;margin:30px 0">
<a href="' . route('tienda') . '" style="display:inline-block;background:#2563eb;color:white;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:bold">Ir a la tienda</a>
</div>
<p style="color:#999;font-size:13px">Si no creaste esta cuenta, puedes ignorar este mensaje.</p>
</div>
<div style="background:#f9fafb;padding:16px 28px;text-align:center;color:#9ca3af;font-size:12px">&copy; ' . date('Y') . ' NeusPhone &mdash; Todos los derechos reservados.</div>
</div>
</body></html>'
            );
    }
}
