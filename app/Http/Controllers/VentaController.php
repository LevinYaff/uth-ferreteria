<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $ventas = Venta::with('user')->orderBy('created_at', 'desc')->get();
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $productos = Producto::where('activo', true)
            ->where('stock', '>', 0)
            ->get();
        return view('ventas.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'observaciones' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Calcular el total de la venta
            $total = 0;
            $detalles = [];

            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);

                // Verificar stock
                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para {$producto->nombre}. Disponible: {$producto->stock}");
                }

                $subtotal = $producto->precio_venta * $item['cantidad'];
                $total += $subtotal;

                $detalles[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $subtotal,
                ];

                // Actualizar stock
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }

            // Crear la venta
            $venta = Venta::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'estado' => 'completada',
                'observaciones' => $request->observaciones,
            ]);

            // Crear los detalles de la venta
            foreach ($detalles as $detalle) {
                $venta->detalles()->create($detalle);
            }

            DB::commit();

            return redirect()->route('ventas.show', $venta->id)
                ->with('success', 'Venta registrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al registrar la venta: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta): View
    {
        $venta->load(['user', 'detalles.producto']);
        return view('ventas.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta): RedirectResponse
    {
        // Las ventas no se editan, solo se pueden cancelar
        return redirect()->route('ventas.show', $venta->id)
            ->with('info', 'Las ventas no pueden ser editadas, solo canceladas.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta): RedirectResponse
    {
        // No permitimos actualizar ventas, solo cambiar su estado
        return redirect()->route('ventas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta): RedirectResponse
    {
        // No permitimos eliminar ventas físicamente, solo cambiar su estado
        return redirect()->route('ventas.index')
            ->with('info', 'Las ventas no pueden ser eliminadas del sistema.');
    }

    /**
     * Cancelar una venta.
     */
    public function cancelar(Venta $venta): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Verificar que la venta no esté ya cancelada
            if ($venta->estado === 'cancelada') {
                return redirect()->route('ventas.show', $venta->id)
                    ->with('info', 'Esta venta ya fue cancelada anteriormente.');
            }

            // Restaurar stock de productos
            foreach ($venta->detalles as $detalle) {
                $producto = $detalle->producto;
                $producto->stock += $detalle->cantidad;
                $producto->save();
            }

            // Cambiar estado de la venta
            $venta->estado = 'cancelada';
            $venta->save();

            DB::commit();

            return redirect()->route('ventas.show', $venta->id)
                ->with('success', 'Venta cancelada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Error al cancelar la venta: ' . $e->getMessage()]);
        }
    }

    /**
     * Genera una factura en PDF para la venta especificada.
     */
    public function facturaPdf(Venta $venta)
    {
        $venta->load(['user', 'detalles.producto']);

        // Configurar PDF para mostrar en navegador en lugar de descargar
        $pdf = PDF::loadView('ventas.factura_pdf', compact('venta'));

        // Retornar el PDF en el navegador con un nombre específico
        return $pdf->stream('factura_venta_' . $venta->id . '.pdf');
    }
}
