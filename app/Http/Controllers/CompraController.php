<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('proveedor', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::where('activo', true)->get();
        $productos = Producto::where('activo', true)->get();

        return view('compras.create', compact('proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_compra' => 'required|date',
            'numero_factura' => 'nullable|string|max:50',
            'numero_orden' => 'nullable|string|max:50',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'archivo_factura' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            foreach ($request->productos as $producto) {
                $subtotal += $producto['cantidad'] * $producto['precio'];
            }

            $impuestos = $request->impuestos ?? 0;
            $descuento = $request->descuento ?? 0;
            $total = $subtotal + $impuestos - $descuento;

            // Almacenar archivo de factura si se proporcionó
            $archivoFacturaPath = null;
            if ($request->hasFile('archivo_factura')) {
                $archivoFacturaPath = $request->file('archivo_factura')->store('facturas_compra', 'public');
            }

            // Crear la compra
            $compra = Compra::create([
                'proveedor_id' => $request->proveedor_id,
                'user_id' => Auth::id(),
                'numero_factura' => $request->numero_factura,
                'numero_orden' => $request->numero_orden,
                'fecha_compra' => $request->fecha_compra,
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'descuento' => $descuento,
                'total' => $total,
                'estado' => 'pendiente',
                'observaciones' => $request->observaciones,
                'archivo_factura' => $archivoFacturaPath,
            ]);

            // Crear los detalles de la compra
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);
                $subtotalItem = $item['cantidad'] * $item['precio'];

                $compra->detalles()->create([
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $subtotalItem,
                    'cantidad_recibida' => 0,
                ]);

                // Actualizar el precio de compra en la relación producto-proveedor
                $producto->proveedores()->syncWithoutDetaching([
                    $request->proveedor_id => [
                        'precio_compra' => $item['precio'],
                        'es_proveedor_principal' => true,
                    ]
                ]);
            }

            DB::commit();

            return redirect()->route('compras.show', $compra->id)
                ->with('success', 'Compra registrada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al registrar la compra: ' . $e->getMessage()]);
        }
    }

    public function show(Compra $compra)
    {
        $compra->load(['proveedor', 'user', 'detalles.producto']);

        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        // Solo se pueden editar compras pendientes
        if ($compra->estado !== 'pendiente') {
            return redirect()->route('compras.show', $compra->id)
                ->with('info', 'Solo se pueden editar compras pendientes.');
        }

        $compra->load(['proveedor', 'detalles.producto']);
        $proveedores = Proveedor::where('activo', true)->get();
        $productos = Producto::where('activo', true)->get();

        return view('compras.edit', compact('compra', 'proveedores', 'productos'));
    }

    public function update(Request $request, Compra $compra)
    {
        // Validar que la compra esté pendiente
        if ($compra->estado !== 'pendiente') {
            return redirect()->route('compras.show', $compra->id)
                ->with('error', 'Solo se pueden editar compras pendientes.');
        }

        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_compra' => 'required|date',
            'numero_factura' => 'nullable|string|max:50',
            'numero_orden' => 'nullable|string|max:50',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'archivo_factura' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            foreach ($request->productos as $producto) {
                $subtotal += $producto['cantidad'] * $producto['precio'];
            }

            $impuestos = $request->impuestos ?? 0;
            $descuento = $request->descuento ?? 0;
            $total = $subtotal + $impuestos - $descuento;

            // Actualizar archivo de factura si se proporcionó uno nuevo
            $archivoFacturaPath = $compra->archivo_factura;
            if ($request->hasFile('archivo_factura')) {
                // Eliminar archivo anterior si existe
                if ($compra->archivo_factura) {
                    Storage::disk('public')->delete($compra->archivo_factura);
                }
                $archivoFacturaPath = $request->file('archivo_factura')->store('facturas_compra', 'public');
            }

            // Actualizar la compra
            $compra->update([
                'proveedor_id' => $request->proveedor_id,
                'numero_factura' => $request->numero_factura,
                'numero_orden' => $request->numero_orden,
                'fecha_compra' => $request->fecha_compra,
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'descuento' => $descuento,
                'total' => $total,
                'observaciones' => $request->observaciones,
                'archivo_factura' => $archivoFacturaPath,
            ]);

            // Eliminar detalles anteriores
            $compra->detalles()->delete();

            // Crear nuevos detalles
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);
                $subtotalItem = $item['cantidad'] * $item['precio'];

                $compra->detalles()->create([
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $subtotalItem,
                    'cantidad_recibida' => 0,
                ]);

                // Actualizar el precio de compra en la relación producto-proveedor
                $producto->proveedores()->syncWithoutDetaching([
                    $request->proveedor_id => [
                        'precio_compra' => $item['precio'],
                    ]
                ]);
            }

            DB::commit();

            return redirect()->route('compras.show', $compra->id)
                ->with('success', 'Compra actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar la compra: ' . $e->getMessage()]);
        }
    }

    public function destroy(Compra $compra)
    {
        // Solo se pueden eliminar compras pendientes
        if ($compra->estado !== 'pendiente') {
            return redirect()->route('compras.show', $compra->id)
                ->with('error', 'Solo se pueden eliminar compras pendientes.');
        }

        try {
            DB::beginTransaction();

            // Eliminar archivo de factura si existe
            if ($compra->archivo_factura) {
                Storage::disk('public')->delete($compra->archivo_factura);
            }

            // Eliminar la compra (los detalles se eliminarán en cascada)
            $compra->delete();

            DB::commit();

            return redirect()->route('compras.index')
                ->with('success', 'Compra eliminada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar la compra: ' . $e->getMessage());
        }
    }

    // Método para recibir productos de una compra
    public function recibir(Request $request, Compra $compra)
    {
        // Validar que la compra no esté ya recibida o cancelada
        if ($compra->estado === 'recibida' || $compra->estado === 'cancelada') {
            return redirect()->route('compras.show', $compra->id)
                ->with('error', 'Esta compra ya ha sido procesada.');
        }

        $request->validate([
            'detalles' => 'required|array',
            'detalles.*.id' => 'required|exists:detalle_compras,id',
            'detalles.*.cantidad_recibida' => 'required|integer|min:0',
            'fecha_recepcion' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $totalRecibido = true;
            $algunoRecibido = false;

            foreach ($request->detalles as $detalle) {
                $detalleCompra = DetalleCompra::findOrFail($detalle['id']);

                // Verificar que el detalle pertenezca a esta compra
                if ($detalleCompra->compra_id !== $compra->id) {
                    throw new \Exception('Detalle no pertenece a esta compra.');
                }

                $cantidadAnterior = $detalleCompra->cantidad_recibida;
                $cantidadNueva = $detalle['cantidad_recibida'];

                // Actualizar la cantidad recibida
                $detalleCompra->update([
                    'cantidad_recibida' => $cantidadNueva
                ]);

                // Actualizar el stock del producto
                $producto = Producto::findOrFail($detalleCompra->producto_id);
                $diferencia = $cantidadNueva - $cantidadAnterior;
                $producto->stock += $diferencia;
                $producto->save();

                // Verificar si todos los productos han sido recibidos completamente
                if ($cantidadNueva < $detalleCompra->cantidad) {
                    $totalRecibido = false;
                }

                if ($cantidadNueva > 0) {
                    $algunoRecibido = true;
                }
            }

            // Actualizar estado de la compra
            $nuevoEstado = 'pendiente';
            if ($totalRecibido) {
                $nuevoEstado = 'recibida';
            } elseif ($algunoRecibido) {
                $nuevoEstado = 'parcial';
            }

            $compra->update([
                'estado' => $nuevoEstado,
                'fecha_recepcion' => $request->fecha_recepcion
            ]);

            DB::commit();

            return redirect()->route('compras.show', $compra->id)
                ->with('success', 'Productos recibidos exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al recibir productos: ' . $e->getMessage());
        }
    }

    // Método para cancelar una compra
    public function cancelar(Compra $compra)
    {
        // Validar que la compra no esté ya recibida o cancelada
        if ($compra->estado === 'recibida' || $compra->estado === 'cancelada') {
            return redirect()->route('compras.show', $compra->id)
                ->with('error', 'Esta compra ya ha sido procesada.');
        }

        try {
            DB::beginTransaction();

            // Si algunos productos ya fueron recibidos, revertir el stock
            foreach ($compra->detalles as $detalle) {
                if ($detalle->cantidad_recibida > 0) {
                    $producto = Producto::findOrFail($detalle->producto_id);
                    $producto->stock -= $detalle->cantidad_recibida;
                    $producto->save();

                    // Resetear cantidad recibida
                    $detalle->update(['cantidad_recibida' => 0]);
                }
            }

            // Actualizar estado de la compra
            $compra->update(['estado' => 'cancelada']);

            DB::commit();

            return redirect()->route('compras.show', $compra->id)
                ->with('success', 'Compra cancelada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al cancelar la compra: ' . $e->getMessage());
        }
    }

    // Método para generar factura PDF
    public function facturaPdf(Compra $compra)
    {
        if (!$compra->archivo_factura) {
            return redirect()->route('compras.show', $compra->id)
                ->with('error', 'Esta compra no tiene una factura adjunta.');
        }

        return view('compras.show-pdf', compact('compra'));
    }

    // Método para mostrar historial de compras por proveedor
    public function historialProveedor(Proveedor $proveedor)
    {
        $compras = Compra::where('proveedor_id', $proveedor->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('compras.historial_proveedor', compact('proveedor', 'compras'));
    }
}
