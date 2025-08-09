<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(): View
    {
        $productos = Producto::with('categoria')->get();
        return view('productos.index', compact('productos'));
    }

    public function porCategoria(Categoria $categoria)
{
    $productos = Producto::where('categoria_id', $categoria->id)
                        ->orderBy('nombre')
                        ->get();

    return view('productos.index', compact('productos', 'categoria'));
}

    public function create(): View
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::where('activo', true)->get(); // <- nuevo
        return view('productos.create', compact('categorias', 'proveedores')); // <- nuevo
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'codigo' => 'nullable|string|max:50|unique:productos',
            'imagen' => 'nullable|image|max:2048',
            'activo' => 'boolean',
            'proveedores' => 'array|nullable',
            'proveedor_principal' => 'nullable|integer'
        ]);

        $data = $request->except('imagen', 'proveedores', 'proveedor_principal');

        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('productos', 'public');
            $data['imagen'] = $imagenPath;
        }

        $producto = Producto::create($data);

        // Asociar proveedores
        if ($request->has('proveedores')) {
            $proveedoresData = [];
            foreach ($request->proveedores as $proveedorId) {
                $proveedoresData[$proveedorId] = [
                    'es_proveedor_principal' => ($proveedorId == $request->proveedor_principal)
                ];
            }
            $producto->proveedores()->sync($proveedoresData);
        }

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Producto $producto): View
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::where('activo', true)->get(); // <- nuevo
        return view('productos.edit', compact('producto', 'categorias', 'proveedores')); // <- nuevo
    }

    public function update(Request $request, Producto $producto): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'codigo' => 'nullable|string|max:50|unique:productos,codigo,' . $producto->id,
            'imagen' => 'nullable|image|max:2048',
            'activo' => 'boolean',
            'proveedores' => 'array|nullable',
            'proveedor_principal' => 'nullable|integer'
        ]);

        $data = $request->except('imagen', 'proveedores', 'proveedor_principal');

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $imagenPath = $request->file('imagen')->store('productos', 'public');
            $data['imagen'] = $imagenPath;
        }

        $producto->update($data);

        // Actualizar proveedores
        if ($request->has('proveedores')) {
            $proveedoresData = [];
            foreach ($request->proveedores as $proveedorId) {
                $proveedoresData[$proveedorId] = [
                    'es_proveedor_principal' => ($proveedorId == $request->proveedor_principal)
                ];
            }
            $producto->proveedores()->sync($proveedoresData);
        } else {
            $producto->proveedores()->detach();
        }

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function reporte(): View
    {
        $productos = Producto::with(['categoria', 'proveedores'])
            ->withCount(['detalleVentas as total_vendido' => function($query) {
                $query->whereHas('venta', function($q) {
                    $q->where('estado', 'completada');
                });
            }])
            ->get();

        return view('productos.reporte', compact('productos'));
    }

    public function ajustarStock(Request $request): RedirectResponse
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer',
            'tipo_ajuste' => 'required|in:sumar,restar',
            'motivo' => 'required|string|max:255'
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        if ($request->tipo_ajuste === 'sumar') {
            $producto->stock += $request->cantidad;
        } else {
            if ($producto->stock < $request->cantidad) {
                return redirect()->back()
                    ->withErrors(['error' => 'No hay suficiente stock para realizar el ajuste.']);
            }
            $producto->stock -= $request->cantidad;
        }

        $producto->save();

        // Aquí podrías registrar el ajuste en una tabla de movimientos si lo deseas

        return redirect()->back()
            ->with('success', 'Stock ajustado correctamente.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
