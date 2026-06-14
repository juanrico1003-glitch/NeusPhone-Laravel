<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $pedidos = Pedido::with(['detalles.producto', 'envio'])
            ->where('usuario_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($pedidos);
    }

    public function show(Request $request, $id)
    {
        $pedido = Pedido::with(['detalles.producto', 'envio'])
            ->where('usuario_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($pedido);
    }
}
