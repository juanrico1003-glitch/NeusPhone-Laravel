<?php
namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $favoritos = Favorito::with('producto')
            ->where('usuario_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('favoritos.index', compact('favoritos') + ['metaTitle' => 'Favoritos - NeusPhone']);
    }

    public function toggle(Request $request, int $id)
    {
        $producto = Producto::findOrFail($id);
        $existing = Favorito::where('usuario_id', Auth::id())->where('producto_id', $id)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Producto eliminado de favoritos';
            $isFavorito = false;
        } else {
            Favorito::create(['usuario_id' => Auth::id(), 'producto_id' => $id]);
            $message = 'Producto agregado a favoritos';
            $isFavorito = true;
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'is_favorito' => $isFavorito, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
