<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Estadísticas generales
        $totalVentas = Venta::where('estado', 'completada')->sum('total') ?? 0;
        $totalProductos = Producto::count();
        $productosAgotados = Producto::where('stock', 0)->count();
        $totalProveedores = Proveedor::count();

        // Ventas recientes
        $ventasRecientes = Venta::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Productos con bajo stock
        $productosBajoStock = Producto::where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->with('categoria')
            ->take(5)
            ->get();

        // Productos más vendidos (top 5)
        $productosMasVendidos = DB::table('detalle_ventas')
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->select(
                'productos.id',
                'productos.nombre',
                DB::raw('SUM(detalle_ventas.cantidad) as total_vendido'),
                DB::raw('SUM(detalle_ventas.subtotal) as total_ingresos')
            )
            ->where('ventas.estado', 'completada')
            ->groupBy('productos.id', 'productos.nombre')
            ->orderBy('total_vendido', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalVentas',
            'totalProductos',
            'productosAgotados',
            'totalProveedores',
            'ventasRecientes',
            'productosBajoStock',
            'productosMasVendidos'
        ));
    }
}
