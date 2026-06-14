<?php
namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PedidosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Pedido::with('usuario', 'detalles.producto')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Cliente', 'Email', 'Teléfono', 'Total', 'Descuento', 'Cupón', 'Estado', 'Productos', 'Fecha'];
    }

    public function map($pedido): array
    {
        $productos = $pedido->detalles->map(fn($d) => $d->producto->nombre . ' x' . $d->cantidad)->implode(' | ');
        return [
            $pedido->id,
            $pedido->usuario?->nombres . ' ' . $pedido->usuario?->apellidos,
            $pedido->usuario?->correo,
            $pedido->usuario?->telefono,
            $pedido->total,
            $pedido->descuento ?? 0,
            $pedido->cupon_id,
            $pedido->estado,
            $productos,
            $pedido->created_at?->format('d/m/Y H:i'),
        ];
    }
}
