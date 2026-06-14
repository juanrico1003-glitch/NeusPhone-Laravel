<?php
namespace App\Exports;

use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsuariosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Usuario::with('rol')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nombres', 'Apellidos', 'Cédula', 'Correo', 'Teléfono', 'Rol', 'Estado', 'Registrado'];
    }

    public function map($usuario): array
    {
        return [
            $usuario->id,
            $usuario->nombres,
            $usuario->apellidos,
            $usuario->cedula,
            $usuario->correo,
            $usuario->telefono,
            $usuario->rol?->nombre,
            $usuario->estado ? 'Activo' : 'Inactivo',
            $usuario->created_at?->format('d/m/Y'),
        ];
    }
}
