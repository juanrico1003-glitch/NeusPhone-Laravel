<?php

namespace App\Exports;

use App\Models\SolicitudServicio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ServiciosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return SolicitudServicio::with('usuario')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Cliente', 'Email', 'Teléfono', 'Tipo', 'Descripción', 'Estado', 'Creado'];
    }

    public function map($servicio): array
    {
        return [
            $servicio->id,
            $servicio->usuario?->nombres . ' ' . $servicio->usuario?->apellidos,
            $servicio->usuario?->correo,
            $servicio->usuario?->telefono,
            $servicio->tipo,
            $servicio->descripcion,
            $servicio->estado,
            $servicio->created_at?->format('d/m/Y H:i'),
        ];
    }
}
