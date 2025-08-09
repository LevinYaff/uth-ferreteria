<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\DetalleVenta;
use App\Models\DetalleCompra;

class MovimientoInventarioController extends Controller
{
    public function index()
    {
        // Obtener movimientos de ventas
        $movimientosVentas = DetalleVenta::with(['venta', 'producto'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($detalle) {
                return [
                    'fecha' => $detalle->created_at,
                    'tipo' => 'Salida (Venta)',
                    'producto' => $detalle->producto->nombre,
                    'cantidad' => $detalle->cantidad,
                    'referencia' => 'Venta #' . $detalle->venta_id,
                ];
            });

        // Obtener movimientos de compras
        $movimientosCompras = DetalleCompra::with(['compra', 'producto'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($detalle) {
                return [
                    'fecha' => $detalle->created_at,
                    'tipo' => 'Entrada (Compra)',
                    'producto' => $detalle->producto->nombre,
                    'cantidad' => $detalle->cantidad,
                    'referencia' => 'Compra #' . $detalle->compra_id,
                ];
            });

        // Combinar y ordenar todos los movimientos por fecha
        $movimientos = $movimientosVentas->concat($movimientosCompras)
            ->sortByDesc('fecha');

        return view('inventario.movimientos.index', compact('movimientos'));
    }
}
