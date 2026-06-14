<?php
namespace App\Http\Controllers;

use App\Exports\InventoryExport;
use App\Exports\PedidosExport;
use App\Exports\ServiciosExport;
use App\Exports\TestimoniosExport;
use App\Exports\UsuariosExport;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function pedidos(Request $request)
    {
        $query = Pedido::with('usuario', 'detalles.producto')->orderBy('created_at', 'desc');
        
        if ($request->estado) $query->where('estado', $request->estado);
        if ($request->fecha_desde) $query->whereDate('created_at', '>=', $request->fecha_desde);
        if ($request->fecha_hasta) $query->whereDate('created_at', '<=', $request->fecha_hasta);

        $pedidos = $query->get();
        $filename = 'pedidos_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($pedidos) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($output, ['ID', 'Cliente', 'Email', 'Total', 'Descuento', 'Estado', 'Cupón', 'Productos', 'Fecha']);

            foreach ($pedidos as $p) {
                $productos = $p->detalles->map(fn($d) => $d->producto->nombre . ' x' . $d->cantidad)->implode(' | ');
                fputcsv($output, [
                    $p->id,
                    $p->usuario?->nombres . ' ' . $p->usuario?->apellidos,
                    $p->usuario?->correo,
                    $p->total,
                    $p->descuento ?? 0,
                    $p->estado,
                    $p->cupon_id,
                    $productos,
                    $p->created_at?->format('d/m/Y H:i'),
                ]);
            }
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function productos(Request $request)
    {
        $query = Producto::with('categoria')->orderBy('created_at', 'desc');
        
        if ($request->categoria_id) $query->where('categoria_id', $request->categoria_id);
        if ($request->search) $query->where('nombre', 'like', "%{$request->search}%");

        $productos = $query->get();
        $filename = 'productos_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($productos) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($output, ['ID', 'Nombre', 'Marca', 'Categoría', 'Precio', 'Stock', 'Tipo', 'Estado', 'Creado']);

            foreach ($productos as $p) {
                fputcsv($output, [
                    $p->id,
                    $p->nombre,
                    $p->marca,
                    $p->categoria?->nombre,
                    $p->precio,
                    $p->stock,
                    $p->tipo,
                    $p->estado ? 'Activo' : 'Inactivo',
                    $p->created_at?->format('d/m/Y'),
                ]);
            }
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function inventarioExcel()
    {
        return Excel::download(new InventoryExport, 'inventario_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function serviciosExcel()
    {
        return Excel::download(new ServiciosExport, 'servicios_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function pedidosExcel()
    {
        return Excel::download(new PedidosExport, 'pedidos_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function usuariosExcel()
    {
        return Excel::download(new UsuariosExport, 'usuarios_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function testimoniosExcel()
    {
        return Excel::download(new TestimoniosExport, 'comentarios_' . now()->format('Ymd_His') . '.xlsx');
    }
}
