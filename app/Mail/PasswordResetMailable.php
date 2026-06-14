<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PasswordResetMailable extends Mailable
{
    public string $resetUrl;
    public string $userName;

    public function __construct(string $resetUrl, string $userName)
    {
        $this->resetUrl = $resetUrl;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Restablece tu contraseña - NeusPhone')
            ->html(
                '<!DOCTYPE html>
<html><head><meta charset="utf-8"></head><body style="font-family:Arial,sans-serif;padding:20px;background:#f5f5f5">
<div style="max-width:600px;margin:0 auto;background:white;border-radius:12px;overflow:hidden">
<div style="background:#2563eb;padding:20px;text-align:center">
<h1 style="color:white;margin:0;font-size:22px">NeusPhone</h1>
</div>
<div style="padding:30px">
<h2 style="color:#333;margin-top:0">¡Hola, ' . htmlspecialchars($this->userName) . '!</h2>
<p style="color:#555;line-height:1.6">Recibiste este correo porque solicitaste restablecer tu contraseña en NeusPhone.</p>
<div style="text-align:center;margin:30px 0">
<a href="' . $this->resetUrl . '" style="display:inline-block;background:#2563eb;color:white;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:bold">Restablecer contraseña</a>
</div>
<p style="color:#555;line-height:1.6">Este enlace expirará en 60 minutos.</p>
<p style="color:#999;font-size:13px">Si no solicitaste este cambio, puedes ignorar este mensaje.</p>
</div>
</div>
</body></html>'
            );
    }
}
