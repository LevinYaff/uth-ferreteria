<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Producto;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria): View
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
     // Verificar si hay productos asociados a esta categoría
    $productosAsociados = Producto::where('categoria_id', $categoria->id)->exists();

    if ($productosAsociados) {
        // Si hay productos asociados, redirigir con mensaje de error
        return redirect()->route('categorias.index')
            ->with('error', 'No se puede eliminar la categoría porque tiene productos asociados. Debe reasignar o eliminar estos productos primero.');
    }

    // Si no hay productos asociados, proceder con la eliminación
    try {
        $categoria->delete();
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    } catch (\Exception $e) {
        return redirect()->route('categorias.index')
            ->with('error', 'Ha ocurrido un error al intentar eliminar la categoría: ' . $e->getMessage());
    }
}
}
