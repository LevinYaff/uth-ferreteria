<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'documento' => 'nullable|string|max:50|unique:clientes',
            'tipo_documento' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:20',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'fecha_nacimiento' => 'nullable|date',
            'notas' => 'nullable|string',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente): View
    {
        // Cargar ventas recientes
        $ventasRecientes = $cliente->ventas()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Obtener productos más comprados
        $productosMasComprados = $cliente->productosMasComprados();

        // Estadísticas del cliente
        $totalVentas = $cliente->ventas()->where('estado', 'completada')->count();
        $totalGastado = $cliente->total_gastado;

        return view('clientes.show', compact('cliente', 'ventasRecientes', 'productosMasComprados', 'totalVentas', 'totalGastado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'documento' => 'nullable|string|max:50|unique:clientes,documento,' . $cliente->id,
            'tipo_documento' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:20',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'fecha_nacimiento' => 'nullable|date',
            'notas' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente): RedirectResponse
    {
        // Verificar si el cliente tiene ventas asociadas
        if ($cliente->ventas()->count() > 0) {
            return redirect()->route('clientes.index')
                ->with('error', 'No se puede eliminar el cliente porque tiene ventas asociadas.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }

    /**
     * Mostrar historial de compras del cliente.
     */
    public function historialCompras(Cliente $cliente): View
    {
        $ventas = $cliente->ventas()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('clientes.historial', compact('cliente', 'ventas'));
    }

    /**
     * Mostrar mapa con la ubicación del cliente.
     */
    public function mapa(Cliente $cliente): View
    {
        return view('clientes.mapa', compact('cliente'));
    }
}
