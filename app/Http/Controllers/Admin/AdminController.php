<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Testimonio;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $productosActivos = Producto::where('estado', 1)->count();
        $productosInactivos = Producto::where('estado', 0)->count();
        $totalProductos = Producto::count();
        $sinStock = Producto::where('stock', '<=', 0)->count();

        $pendientes = Pedido::where('estado', 'pendiente')->count();
        $pagados = Pedido::where('estado', 'pagado')->count();
        $enviados = Pedido::where('estado', 'enviado')->count();
        $entregados = Pedido::where('estado', 'entregado')->count();
        $cancelados = Pedido::where('estado', 'cancelado')->count();
        $totalPedidos = Pedido::count();

        $serviciosPendientes = \App\Models\SolicitudServicio::where('estado', 'pendiente')->count();

        $ventas = Pedido::whereIn('estado', ['pagado', 'enviado', 'entregado'])->sum('total');
        $ventasMes = Pedido::whereIn('estado', ['pagado', 'enviado', 'entregado'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        $pedidosMes = Pedido::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalUsuarios = Usuario::count();
        $usuariosNuevosMes = Usuario::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Ventas por mes (últimos 6 meses)
        $ventasPorMes = Pedido::whereIn('estado', ['pagado', 'enviado', 'entregado'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn($i) => $i->year . '-' . str_pad($i->month, 2, '0', STR_PAD_LEFT));

        $meses = [];
        $ventasArray = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->year . '-' . str_pad($date->month, 2, '0', STR_PAD_LEFT);
            $label = $date->locale('es')->isoFormat('MMM YYYY');
            $meses[] = $label;
            $ventasArray[] = (int) ($ventasPorMes[$key]->total ?? 0);
        }

        // Productos con bajo stock
        $bajoStock = Producto::where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->take(15)
            ->get();

        $agotados = Producto::where('stock', '<=', 0)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Productos más vendidos
        $masVendidos = PedidoDetalle::select(
                'producto_id',
                DB::raw('SUM(cantidad) as total_vendido'),
                DB::raw('SUM(precio * cantidad) as total_ingresos')
            )
            ->whereHas('pedido', fn($q) => $q->whereIn('estado', ['pagado', 'enviado', 'entregado']))
            ->groupBy('producto_id')
            ->orderBy('total_vendido', 'desc')
            ->take(10)
            ->with('producto')
            ->get();

        // Productos más vistos
        $masVistos = Producto::where('estado', 1)
            ->orderBy('visitas', 'desc')
            ->take(10)
            ->get(['id', 'nombre', 'visitas', 'precio', 'stock']);

        // Clientes con más pedidos
        $topClientes = Pedido::select(
                'usuario_id',
                DB::raw('COUNT(*) as total_pedidos'),
                DB::raw('SUM(total) as total_gastado')
            )
            ->whereIn('estado', ['pagado', 'enviado', 'entregado'])
            ->groupBy('usuario_id')
            ->orderBy('total_pedidos', 'desc')
            ->take(10)
            ->with('usuario')
            ->get();

        // Pedidos recientes
        $pedidosRecientes = Pedido::with(['usuario', 'detalles'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Distribución por categoría
        $distribucionCategorias = Producto::where('estado', 1)
            ->select('categoria_id', DB::raw('COUNT(*) as total'))
            ->groupBy('categoria_id')
            ->with('categoria')
            ->orderBy('total', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'productosActivos', 'productosInactivos', 'totalProductos', 'sinStock',
            'pendientes', 'pagados', 'enviados', 'entregados', 'cancelados', 'totalPedidos',
            'serviciosPendientes',
            'ventas', 'ventasMes', 'pedidosMes',
            'totalUsuarios', 'usuariosNuevosMes',
            'meses', 'ventasArray',
            'bajoStock', 'agotados',
            'masVendidos', 'masVistos',
            'topClientes', 'pedidosRecientes',
            'distribucionCategorias',
        ));
    }

    public function testimonios()
    {
        $testimonios = Testimonio::with('usuario')->orderBy('created_at', 'desc')->get();
        return view('admin.testimonios.index', compact('testimonios'));
    }

    public function toggleTestimonio($id)
    {
        $testimonio = Testimonio::findOrFail($id);
        $testimonio->estado = $testimonio->estado == 1 ? 0 : 1;
        $testimonio->save();

        return redirect()->back()->with('success', 'Estado del testimonio actualizado correctamente.');
    }
}
