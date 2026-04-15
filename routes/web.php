<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\PedidoAdminController;
use App\Http\Controllers\Admin\ServicioAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\TestimonioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Pagina principal
Route::get('/', function () {
    return redirect()->route('dashboard.main');
});

Route::get('/dashboard', function () {
    $productosEstrella = \App\Models\Producto::where('estado', 1)->inRandomOrder()->take(4)->get();
    $testimonios = \App\Models\Testimonio::with('usuario')->where('estado', 1)->inRandomOrder()->take(3)->get();
    return view('landing', compact('productosEstrella', 'testimonios'));
})->name('dashboard.main');

// TIENDA
Route::get('/tienda', [TiendaController::class, 'index'])
    ->name('tienda');

Route::get('/tienda/producto/{id}', [TiendaController::class, 'show'])
    ->name('tienda.producto');

// CARRITO
Route::get('/carrito', [CarritoController::class, 'index'])
    ->name('carrito.index');

Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])
    ->name('carrito.agregar');

Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])
    ->name('carrito.eliminar');

Route::post('/carrito/confirmar', [CarritoController::class, 'confirmar'])
    ->middleware('auth')
    ->name('carrito.confirmar');

// CLIENTE (requiere login)
Route::middleware('auth')->group(function () {

    // Panel cliente (interno)
    Route::get('/mi-cuenta', function () {
        $user = Auth::user();
        $pedidosCount = \App\Models\Pedido::where('usuario_id', $user->id)->count();
        $serviciosCount = \App\Models\SolicitudServicio::where('usuario_id', $user->id)->count();

        return view('dashboard', compact('pedidosCount', 'serviciosCount'));
    })->name('cliente.dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pedidos cliente
    Route::get('/mis-pedidos', [PedidoController::class, 'index'])
        ->name('pedidos.index');

    Route::get('/mis-pedidos/{id}', [PedidoController::class, 'show'])
        ->name('pedidos.show');

    // Servicios cliente
    Route::get('/servicios', [ServicioController::class, 'index'])
        ->name('servicios.index');

    Route::get('/servicios/crear', [ServicioController::class, 'create'])
        ->name('servicios.create');

    Route::post('/servicios', [ServicioController::class, 'store'])
        ->name('servicios.store');

    // Testimonios cliente
    Route::get('/reseñas/nueva', [TestimonioController::class, 'create'])->name('testimonios.create');
    Route::post('/reseñas', [TestimonioController::class, 'store'])->name('testimonios.store');
});

// ADMIN (requiere rol admin)
Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard admin
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    // Productos
    Route::get('/admin/productos/{id}/estado', [ProductoController::class, 'toggleEstado'])
        ->name('admin.productos.estado');

    Route::resource('/admin/productos', ProductoController::class)
        ->names('admin.productos');

    // Pedidos
    Route::get('/admin/pedidos', [PedidoAdminController::class, 'index'])
        ->name('admin.pedidos.index');

    Route::get('/admin/pedidos/{id}', [PedidoAdminController::class, 'show'])
        ->name('admin.pedidos.show');

    Route::post('/admin/pedidos/{id}/estado', [PedidoAdminController::class, 'cambiarEstado'])
        ->name('admin.pedidos.estado');

    // Servicios admin
    Route::get('/admin/servicios', [ServicioAdminController::class, 'index'])
        ->name('admin.servicios.index');

    Route::post('/admin/servicios/{id}/estado', [ServicioAdminController::class, 'cambiarEstado'])
        ->name('admin.servicios.estado');

    // Testimonios admin
    Route::get('/admin/testimonios', [AdminController::class, 'testimonios'])
        ->name('admin.testimonios');
    Route::post('/admin/testimonios/{id}/toggle', [AdminController::class, 'toggleTestimonio'])
        ->name('admin.testimonios.toggle');
});

Route::post('/chatbot/recomendar', [ChatbotController::class, 'recomendar'])
    ->middleware('throttle:30,1')
    ->name('chatbot.recomendar');

// AUTENTICACIÓN
require __DIR__ . '/auth.php';
