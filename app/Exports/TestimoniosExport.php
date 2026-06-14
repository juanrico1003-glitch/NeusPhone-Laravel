<?php
namespace App\Exports;

use App\Models\Testimonio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TestimoniosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Testimonio::with('usuario', 'producto')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Usuario', 'Email', 'Producto', 'Comentario', 'Estado', 'Creado'];
    }

    public function map($testimonio): array
    {
        return [
            $testimonio->id,
            $testimonio->usuario?->nombres . ' ' . $testimonio->usuario?->apellidos,
            $testimonio->usuario?->correo,
            $testimonio->producto?->nombre ?? '—',
            $testimonio->comentario,
            $testimonio->estado ? 'Aprobado' : 'Pendiente',
            $testimonio->created_at?->format('d/m/Y H:i'),
        ];
    }
}
