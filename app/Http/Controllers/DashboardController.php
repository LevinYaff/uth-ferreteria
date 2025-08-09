<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Datos comunes
        $totalProductos = Producto::count();
        $productosAgotados = Producto::where('stock', 0)->count();
        $productosBajoStock = Producto::where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->with('categoria')
            ->get();
        $totalProveedores = Proveedor::count();

                // Renderizar vista según el rol del usuario
        if ($user->role === User::ROLE_VENDEDOR) {
            return $this->vendedorDashboard($user);
        } elseif ($user->role === User::ROLE_INVENTARIO) {
            return $this->inventarioDashboard($totalProductos, $productosAgotados, $productosBajoStock, $totalProveedores);
        } elseif ($user->role === User::ROLE_COMPRAS) {
            return $this->comprasDashboard($totalProveedores, $productosAgotados, $productosBajoStock);
        } elseif ($user->role === User::ROLE_SUPERVISOR) {
            return $this->supervisorDashboard($productosBajoStock);
        }

        // Por defecto, mostrar dashboard de admin
        return $this->adminDashboard($totalProductos, $productosAgotados, $productosBajoStock, $totalProveedores);
    }

    protected function vendedorDashboard(User $user): View
    {
        $hoy = Carbon::today();
        $inicioSemana = Carbon::now()->startOfWeek();
        $inicioMes = Carbon::now()->startOfMonth();

        // Estadísticas de ventas del vendedor
        $ventasHoy = Venta::where('user_id', $user->id)
            ->whereDate('created_at', $hoy)
            ->where('estado', 'completada')
            ->sum('total');

        $ventasSemana = Venta::where('user_id', $user->id)
            ->where('created_at', '>=', $inicioSemana)
            ->where('estado', 'completada')
            ->sum('total');

        $ventasMes = Venta::where('user_id', $user->id)
            ->where('created_at', '>=', $inicioMes)
            ->where('estado', 'completada')
            ->sum('total');

        // Ventas recientes del vendedor
        $ventasRecientes = Venta::where('user_id', $user->id)
            ->with(['cliente'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Productos disponibles
        $productos = Producto::where('stock', '>', 0)
            ->with('categoria')
            ->orderBy('nombre')
            ->get();

        return view('dashboard.vendedor', compact(
            'ventasHoy',
            'ventasSemana',
            'ventasMes',
            'ventasRecientes',
            'productos'
        ));
    }

    private function inventarioDashboard(int $totalProductos, int $productosAgotados, $productosBajoStock, int $totalProveedores): View
    {
        // Productos agotados lista
        $productosAgotadosLista = Producto::where('stock', 0)
            ->with(['categoria'])
            ->orderBy('nombre')
            ->get();

        // Lista completa de productos
        $productos = Producto::with('categoria')
            ->orderBy('nombre')
            ->get();

        return view('dashboard.inventario', compact(
            'totalProductos',
            'productosAgotados',
            'productosBajoStock',
            'totalProveedores',
            'productosAgotadosLista',
            'productos'
        ));
    }

    protected function comprasDashboard(int $totalProveedores, int $productosAgotados, $productosBajoStock): View
    {
        // Estadísticas de compras
        $comprasPendientes = Compra::where('estado', 'pendiente')->count();
        $comprasMes = Compra::whereMonth('created_at', Carbon::now()->month)->count();

        // Compras recientes
        $comprasRecientes = Compra::with('proveedor')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Productos para reabastecimiento
        $productosReabastecer = Producto::where('stock', '<=', 5)
            ->with(['ultimo_proveedor'])
            ->orderBy('stock')
            ->get();

        return view('dashboard.compras', compact(
            'comprasPendientes',
            'comprasMes',
            'totalProveedores',
            'productosAgotados',
            'comprasRecientes',
            'productosReabastecer'
        ));
    }

    protected function supervisorDashboard($productosBajoStock): View
    {
        // Estadísticas de ventas
        $totalVentas = Venta::where('estado', 'completada')->sum('total') ?? 0;
        $ventasHoy = Venta::whereDate('created_at', Carbon::today())
            ->where('estado', 'completada')
            ->sum('total');

        // Obtener cantidad de productos agotados
        $productosAgotados = Producto::where('stock', 0)->count();

        // Productos más vendidos
        $productosMasVendidos = DB::table('detalle_ventas')
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->select(
                'productos.nombre',
                DB::raw('SUM(detalle_ventas.cantidad) as total_vendido')
            )
            ->where('ventas.estado', 'completada')
            ->groupBy('productos.id', 'productos.nombre')
            ->orderBy('total_vendido', 'desc')
            ->take(5)
            ->get();

        // Ventas recientes con más detalles
        $ventasRecientes = Venta::with(['user', 'cliente', 'detalles.producto'])
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();

        return view('dashboard.supervisor', compact(
            'totalVentas',
            'ventasHoy',
            'productosBajoStock',
            'productosAgotados',
            'productosMasVendidos',
            'ventasRecientes'
        ));
    }

    protected function adminDashboard(int $totalProductos, int $productosAgotados, $productosBajoStock, int $totalProveedores): View
    {
        // Estadísticas generales
        $totalVentas = Venta::where('estado', 'completada')->sum('total') ?? 0;

        // Ventas recientes
        $ventasRecientes = Venta::with('user')
            ->orderBy('created_at', 'desc')
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
