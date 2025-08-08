<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

// rutas públicas
Route::get('/', function () {
    return redirect()->route('login');
    Route::post('/theme', [ThemeController::class, 'update'])->name('theme.update');
});

// rutas autenticadas
Route::middleware('auth')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // rutas para vendedores y admin
    Route::middleware(['role:admin,vendedor'])->group(function () {
        // productos
        Route::resource('productos', ProductoController::class);

        // ventas
        Route::resource('ventas', VentaController::class);
        Route::post('ventas/{venta}/cancelar', [VentaController::class, 'cancelar'])->name('ventas.cancelar');
        Route::get('ventas/{venta}/factura-pdf', [VentaController::class, 'facturaPdf'])->name('ventas.factura-pdf');

        // clientes
        Route::resource('clientes', ClienteController::class);
        Route::get('clientes/{cliente}/historial', [ClienteController::class, 'historialCompras'])->name('clientes.historial');
        Route::get('clientes/{cliente}/mapa', [ClienteController::class, 'mapa'])->name('clientes.mapa');

        //entregas de ventas
        route::post('ventas/{venta}/entregar', [VentaController::class, 'entregar'])->name('ventas.entregar');
    });

    // rutas para admin
    Route::middleware(['role:admin'])->group(function () {
        // categorías
        Route::resource('categorias', CategoriaController::class);

        // proveedores
        Route::resource('proveedores', ProveedorController::class)->parameters([
            'proveedores' => 'proveedor'
        ]);

        // crear nuevos usuarios
        Route::resource('users', UserController::class);
        Route::post('/theme', [ThemeController::class, 'update'])->name('theme.update');

        // Compras
        Route::resource('compras', CompraController::class);
        Route::post('compras/{compra}/recibir', [CompraController::class, 'recibir'])->name('compras.recibir');
        Route::post('compras/{compra}/cancelar', [CompraController::class, 'cancelar'])->name('compras.cancelar');
        Route::get('compras/{compra}/factura-pdf', [CompraController::class, 'facturaPdf'])->name('compras.factura-pdf');
        Route::get('proveedores/{proveedor}/compras', [CompraController::class, 'historialProveedor'])->name('proveedores.compras');

        // Productos por proveedor
        Route::get('proveedores/{proveedor}/productos', [ProveedorController::class, 'productos'])->name('proveedores.productos');
    });
});

require __DIR__ . '/auth.php';
