<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(): View
    {
        return view('reportes.index');
    }

    public function ventas(Request $request): View
    {
        $ventas = Venta::with(['user', 'cliente'])
            ->when($request->fecha_inicio, function($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->fecha_inicio);
            })
            ->when($request->fecha_fin, function($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->fecha_fin);
            })
            ->get();

        $estadisticas = [
            'total_ventas' => $ventas->where('estado', 'completada')->sum('total'),
            'cantidad_ventas' => $ventas->where('estado', 'completada')->count(),
            'promedio_venta' => $ventas->where('estado', 'completada')->avg('total'),
            'ventas_canceladas' => $ventas->where('estado', 'cancelada')->count(),
        ];

        return view('reportes.ventas', compact('ventas', 'estadisticas'));
    }

    public function inventario(): View
    {
        $productos = Producto::with('categoria')
            ->withCount(['detalleVentas as total_vendido' => function($query) {
                $query->whereHas('venta', function($q) {
                    $q->where('estado', 'completada');
                });
            }])
            ->get();

        $estadisticas = [
            'total_productos' => $productos->count(),
            'valor_inventario' => $productos->sum(DB::raw('stock * precio_venta')),
            'productos_agotados' => $productos->where('stock', 0)->count(),
            'productos_bajo_stock' => $productos->where('stock', '<=', 5)->where('stock', '>', 0)->count(),
        ];

        return view('reportes.inventario', compact('productos', 'estadisticas'));
    }

    public function compras(Request $request): View
    {
        $compras = Compra::with(['proveedor', 'user'])
            ->when($request->fecha_inicio, function($query) use ($request) {
                $query->whereDate('fecha_compra', '>=', $request->fecha_inicio);
            })
            ->when($request->fecha_fin, function($query) use ($request) {
                $query->whereDate('fecha_compra', '<=', $request->fecha_fin);
            })
            ->get();

        $estadisticas = [
            'total_compras' => $compras->where('estado', 'recibida')->sum('total'),
            'cantidad_compras' => $compras->where('estado', 'recibida')->count(),
            'compras_pendientes' => $compras->where('estado', 'pendiente')->count(),
            'compras_canceladas' => $compras->where('estado', 'cancelada')->count(),
        ];

        return view('reportes.compras', compact('compras', 'estadisticas'));
    }

    public function actividad(): View
    {
        $usuarios = User::withCount([
            'ventas' => function($query) {
                $query->where('estado', 'completada');
            }
        ])->get();

        $actividad = DB::table('users')
            ->leftJoin('ventas', 'users.id', '=', 'ventas.user_id')
            ->select('users.name', DB::raw('COUNT(ventas.id) as total_ventas'), DB::raw('SUM(ventas.total) as total_vendido'))
            ->where('ventas.estado', 'completada')
            ->groupBy('users.id', 'users.name')
            ->get();

        return view('reportes.actividad', compact('usuarios', 'actividad'));
    }
}
