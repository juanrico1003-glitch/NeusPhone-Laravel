<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Producto::with('categoria')->orderBy('nombre')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Marca', 'Categoría', 'Precio', 'Stock', 'Tipo', 'Estado', 'Creado'];
    }

    public function map($producto): array
    {
        return [
            $producto->id,
            $producto->nombre,
            $producto->marca,
            $producto->categoria?->nombre,
            $producto->precio,
            $producto->stock,
            $producto->tipo,
            $producto->estado ? 'Activo' : 'Inactivo',
            $producto->created_at?->format('d/m/Y'),
        ];
    }
}
