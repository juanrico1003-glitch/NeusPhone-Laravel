<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaController extends Controller
{
    public function descargar(int $id)
    {
        $pedido = Pedido::with(['detalles.producto', 'envio', 'usuario'])
            ->where('id', $id)
            ->where('usuario_id', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('facturas.pedido', compact('pedido'));

        return $pdf->download("factura-{$pedido->id}.pdf");
    }

    public function adminDescargar(int $id)
    {
        $pedido = Pedido::with(['detalles.producto', 'envio', 'usuario'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('facturas.pedido', compact('pedido'));

        return $pdf->download("factura-{$pedido->id}.pdf");
    }
}
