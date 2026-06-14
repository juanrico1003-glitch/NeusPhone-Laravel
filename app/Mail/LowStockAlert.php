<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowStockAlert extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $bajoStock;
    public $agotados;

    public function __construct($bajoStock, $agotados)
    {
        $this->bajoStock = $bajoStock;
        $this->agotados = $agotados;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Stock Crítico - NeusPhone')
            ->html(
                '<!DOCTYPE html>
<html><head><meta charset="utf-8"></head>
<body style="font-family:Arial,sans-serif;background:#f5f5f5;padding:20px">
<div style="max-width:600px;margin:0 auto;background:white;border-radius:12px;overflow:hidden">
<div style="background:#dc2626;padding:20px;text-align:center">
<h1 style="color:white;margin:0;font-size:22px">Stock Crítico - NeusPhone</h1>
</div>
<div style="padding:30px">
<h2 style="color:#333;margin-top:0">Productos con inventario bajo</h2>
<p style="color:#555;line-height:1.6">Se detectaron productos con stock crítico en el inventario.</p>
' . ($this->bajoStock->count() > 0 ? '<h3 style="color:#d97706;margin-top:20px">Stock Bajo (1-5 unidades)</h3>
<table style="width:100%;border-collapse:collapse;margin:10px 0">
<tr style="background:#fef3c7;"><th style="padding:8px;text-align:left;border-bottom:1px solid #fde68a">Producto</th><th style="padding:8px;text-align:center;border-bottom:1px solid #fde68a">Stock</th></tr>
' . implode('', $this->bajoStock->map(fn($p) => '<tr><td style="padding:8px;border-bottom:1px solid #f3f4f6">' . htmlspecialchars($p->nombre) . '</td><td style="padding:8px;text-align:center;color:#d97706;font-weight:bold">' . $p->stock . '</td></tr>')->toArray()) . '</table>' : '')
. ($this->agotados->count() > 0 ? '<h3 style="color:#dc2626;margin-top:20px">Agotados (0 unidades)</h3>
<table style="width:100%;border-collapse:collapse;margin:10px 0">
<tr style="background:#fef2f2;"><th style="padding:8px;text-align:left;border-bottom:1px solid #fecaca">Producto</th><th style="padding:8px;text-align:center;border-bottom:1px solid #fecaca">Stock</th></tr>
' . implode('', $this->agotados->map(fn($p) => '<tr><td style="padding:8px;border-bottom:1px solid #f3f4f6">' . htmlspecialchars($p->nombre) . '</td><td style="padding:8px;text-align:center;color:#dc2626;font-weight:bold">' . $p->stock . '</td></tr>')->toArray()) . '</table>' : '')
. '<div style="text-align:center;margin-top:28px">
<a href="' . route('admin.productos.index') . '" style="background:#2563eb;color:white;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:bold;display:inline-block">Gestionar inventario</a>
</div>
</div>
<div style="background:#f9fafb;padding:16px 28px;text-align:center;color:#9ca3af;font-size:12px">&copy; ' . date('Y') . ' NeusPhone &mdash; Mensaje automático del sistema.</div>
</div>
</body></html>'
            );
    }
}
