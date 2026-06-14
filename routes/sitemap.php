<?php
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', function () {
    $productos = Producto::where('estado', 1)->get();
    $categorias = Categoria::where('estado', 1)->get();

    return response()->view('sitemap', compact('productos', 'categorias'))->header('Content-Type', 'text/xml');
});
