<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});

// Rutas autenticadas
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Rutas para vendedores y admin
    Route::middleware(['role:admin,vendedor'])->group(function () {
        // Productos
        Route::resource('productos', ProductoController::class);

        // Ventas
        Route::resource('ventas', VentaController::class);
        Route::post('ventas/{venta}/cancelar', [VentaController::class, 'cancelar'])->name('ventas.cancelar');

    });

    // Rutas solo para admin
    Route::middleware(['role:admin'])->group(function () {
        // Categorías
        Route::resource('categorias', CategoriaController::class);

        // Proveedores
        Route::resource('proveedores', ProveedorController::class);
    });
});

require __DIR__.'/auth.php';
