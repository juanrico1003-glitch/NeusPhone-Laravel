<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CuponAdminController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\PedidoAdminController;
use App\Http\Controllers\Admin\ServicioAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TestimonioController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\WompiController;
use App\Http\Controllers\Admin\VarianteProductoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Pagina principal
Route::get('/', function () {
    return redirect()->route('dashboard.main');
});

Route::get('/dashboard', function () {
    $ofertas = \App\Models\Producto::where('estado', 1)->where('descuento', '>', 0)->where('stock', '>', 0)->inRandomOrder()->take(4)->get();
    $productosEstrella = $ofertas->count() > 0 ? $ofertas : \App\Models\Producto::where('estado', 1)->inRandomOrder()->take(4)->get();
    $testimonios = \App\Models\Testimonio::with('usuario')->where('estado', 1)->inRandomOrder()->take(3)->get();
    return view('landing', compact('productosEstrella', 'testimonios') + ['metaTitle' => 'Inicio - NeusPhone']);
})->name('dashboard.main');

// Paginas legales
Route::view('/politicas', 'politicas')->name('politicas');
Route::view('/terminos', 'terminos')->name('terminos');

// Tienda
Route::get('/tienda', [TiendaController::class, 'index'])
    ->name('tienda')->middleware('cache.response:30');

Route::get('/tienda/producto/{id}', [TiendaController::class, 'show'])
    ->name('tienda.producto')->middleware('cache.response:30');

// Notificacion de stock
Route::post('/producto/{id}/suscribir-stock', [TiendaController::class, 'suscribirStock'])
    ->name('producto.suscribir.stock');

// Carrito
Route::get('/carrito', [CarritoController::class, 'index'])
    ->name('carrito.index');

Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])
    ->name('carrito.agregar');

Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])
    ->name('carrito.eliminar');

Route::post('/carrito/actualizar/{id}', [CarritoController::class, 'actualizar'])
    ->name('carrito.actualizar');

Route::post('/carrito/confirmar', [CarritoController::class, 'confirmar'])
    ->middleware('auth')
    ->name('carrito.confirmar');

// Checkout y Pago (Wompi)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/pagar/{id}', [CheckoutController::class, 'pagar'])->name('checkout.pagar');
    Route::get('/checkout/resultado', [WompiController::class, 'callback'])->name('checkout.resultado');
});

// Simulación de pago para desarrollo (WOMPI_SIMULATED=true)
Route::get('/checkout/simular', [WompiController::class, 'simular'])
    ->middleware('auth')
    ->name('checkout.simular');

// Webhook Wompi (público)
Route::post('/wompi/webhook', [WompiController::class, 'webhook'])->name('wompi.webhook');

    // Chatbot
    Route::post('/chatbot', [ChatbotController::class, 'send']);

// Cliente con login
Route::middleware('auth')->group(function () {

    // Panel cliente
    Route::get('/mi-cuenta', [ClienteController::class, 'dashboard'])->name('cliente.dashboard');

    // Perfil
    Route::post('/mi-cuenta/perfil', [ClienteController::class, 'updateProfile'])->name('cliente.profile.update');
    Route::post('/mi-cuenta/password', [ClienteController::class, 'updatePassword'])->name('cliente.password.update');

    // Eliminar cuenta
    Route::post('/mi-cuenta/eliminar', [ClienteController::class, 'requestDelete'])->name('cliente.delete.request');
    Route::post('/mi-cuenta/cancelar-eliminacion', [ClienteController::class, 'cancelDelete'])->name('cliente.delete.cancel');

    // Favoritos
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
    Route::post('/favoritos/toggle/{id}', [FavoritoController::class, 'toggle'])->name('favoritos.toggle');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pedidos cliente
    Route::get('/mis-pedidos', [PedidoController::class, 'index'])
        ->name('pedidos.index');

    Route::get('/mis-pedidos/{id}', [PedidoController::class, 'show'])
        ->name('pedidos.show');

    Route::post('/mis-pedidos/{id}/cancelar', [PedidoController::class, 'cancelar'])
        ->name('pedidos.cancelar');

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
    Route::post('/tienda/producto/{id}/reseña', [TestimonioController::class, 'storeProducto'])->name('tienda.producto.resena');

    // Factura PDF
    Route::get('/mis-pedidos/{id}/factura', [FacturaController::class, 'descargar'])->name('pedidos.factura');

    // Validar cupon en checkout
    Route::post('/checkout/cupon', [CheckoutController::class, 'aplicarCupon'])->name('checkout.cupon');
    Route::post('/checkout/cupon/remover', [CheckoutController::class, 'removerCupon'])->name('checkout.cupon.remover');
});

// Admin rol
Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard admin
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    // Productos
    Route::get('/admin/productos/{id}/estado', [ProductoController::class, 'toggleEstado'])
        ->name('admin.productos.estado');

    Route::resource('/admin/productos', ProductoController::class)
        ->names('admin.productos');

    Route::get('/admin/productos/{producto}/variantes', [VarianteProductoController::class, 'index'])
        ->name('admin.productos.variantes');
    Route::post('/admin/productos/{producto}/variantes', [VarianteProductoController::class, 'store'])
        ->name('admin.productos.variantes.store');
    Route::put('/admin/productos/{producto}/variantes/{variante}', [VarianteProductoController::class, 'update'])
        ->name('admin.productos.variantes.update');
    Route::delete('/admin/productos/{producto}/variantes/{variante}', [VarianteProductoController::class, 'destroy'])
        ->name('admin.productos.variantes.destroy');

    // Pedidos
    Route::get('/admin/pedidos', [PedidoAdminController::class, 'index'])
        ->name('admin.pedidos.index');

    Route::get('/admin/pedidos/{id}', [PedidoAdminController::class, 'show'])
        ->name('admin.pedidos.show');

    Route::post('/admin/pedidos/{id}/estado', [PedidoAdminController::class, 'cambiarEstado'])
        ->name('admin.pedidos.estado');
    Route::post('/admin/pedidos/{id}/guia', [PedidoAdminController::class, 'actualizarGuia'])
        ->name('admin.pedidos.guia');
    Route::get('/admin/pedidos/{id}/factura', [FacturaController::class, 'adminDescargar'])
        ->name('admin.pedidos.factura');

    // Servicios admin
    Route::get('/admin/servicios', [ServicioAdminController::class, 'index'])
        ->name('admin.servicios.index');

    Route::post('/admin/servicios/{id}/estado', [ServicioAdminController::class, 'cambiarEstado'])
        ->name('admin.servicios.estado');

    // Usuarios admin
    Route::get('/admin/usuarios', [UserController::class, 'index'])
        ->name('admin.usuarios.index');
    Route::get('/admin/usuarios/crear', [UserController::class, 'create'])
        ->name('admin.usuarios.create');
    Route::post('/admin/usuarios', [UserController::class, 'store'])
        ->name('admin.usuarios.store');
    Route::get('/admin/usuarios/{usuario}/editar', [UserController::class, 'edit'])
        ->name('admin.usuarios.edit');
    Route::put('/admin/usuarios/{usuario}', [UserController::class, 'update'])
        ->name('admin.usuarios.update');
    Route::delete('/admin/usuarios/{usuario}', [UserController::class, 'destroy'])
        ->name('admin.usuarios.destroy');
    Route::post('/admin/usuarios/{usuario}/activar', [UserController::class, 'activar'])
        ->name('admin.usuarios.activar');

    // Testimonios admin
    Route::get('/admin/testimonios', [AdminController::class, 'testimonios'])
        ->name('admin.testimonios');
    Route::post('/admin/testimonios/{id}/toggle', [AdminController::class, 'toggleTestimonio'])
        ->name('admin.testimonios.toggle');

    // Cupones admin
    Route::resource('/admin/cupones', CuponAdminController::class)
        ->names('admin.cupones');

    // Imágenes de productos
    Route::post('/admin/productos/{id}/imagen', [ProductoController::class, 'subirImagen'])->name('admin.productos.imagen.subir');
    Route::delete('/admin/productos/imagen/{id}', [ProductoController::class, 'eliminarImagen'])->name('admin.productos.imagen.eliminar');

    // Exportación CSV y Excel
    Route::get('/admin/exportar/pedidos', [ExportController::class, 'pedidos'])->name('admin.exportar.pedidos');
    Route::get('/admin/exportar/productos', [ExportController::class, 'productos'])->name('admin.exportar.productos');
    Route::get('/admin/exportar/inventario', [ExportController::class, 'inventarioExcel'])->name('admin.exportar.inventario');
    Route::get('/admin/exportar/servicios', [ExportController::class, 'serviciosExcel'])->name('admin.exportar.servicios');
    Route::get('/admin/exportar/pedidos-excel', [ExportController::class, 'pedidosExcel'])->name('admin.exportar.pedidos.excel');
    Route::get('/admin/exportar/usuarios', [ExportController::class, 'usuariosExcel'])->name('admin.exportar.usuarios');
    Route::get('/admin/exportar/testimonios', [ExportController::class, 'testimoniosExcel'])->name('admin.exportar.testimonios');
});
// Sitemap
Route::get('/sitemap.xml', function () {
    $productos = \Illuminate\Support\Facades\Cache::remember('sitemap_productos', 3600, function () {
        return \App\Models\Producto::where('estado', 1)->get();
    });
    $categorias = \Illuminate\Support\Facades\Cache::remember('sitemap_categorias', 3600, function () {
        return \App\Models\Categoria::where('estado', 1)->get();
    });
    return response()->view('sitemap', compact('productos', 'categorias'))->header('Content-Type', 'text/xml');
});

// Autenticacion
require __DIR__ . '/auth.php';
