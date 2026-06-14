<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\PedidoController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/perfil', [AuthController::class, 'perfil'])->middleware('auth:sanctum');

Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/productos/{id}', [ProductoController::class, 'show']);
Route::get('/categorias', [ProductoController::class, 'categorias']);

Route::get('/pedidos', [PedidoController::class, 'index'])->middleware('auth:sanctum');
Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->middleware('auth:sanctum');
