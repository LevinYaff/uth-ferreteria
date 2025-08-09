<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Reporte de Inventario') }}
            </h2>
            <div class="flex space-x-2">
                <button onclick="window.print()"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                    Imprimir
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Total Productos</h3>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $estadisticas['total_productos'] }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Valor del Inventario</h3>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">${{ number_format($estadisticas['valor_inventario'], 2) }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Productos Agotados</h3>
                        <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $estadisticas['productos_agotados'] }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Bajo Stock</h3>
                        <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $estadisticas['productos_bajo_stock'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Tabla de Productos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Estado del Inventario</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-700">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 text-left">Código</th>
                                    <th class="py-3 px-6 text-left">Producto</th>
                                    <th class="py-3 px-6 text-left">Categoría</th>
                                    <th class="py-3 px-6 text-left">Stock</th>
                                    <th class="py-3 px-6 text-left">Valor Unitario</th>
                                    <th class="py-3 px-6 text-left">Valor Total</th>
                                    <th class="py-3 px-6 text-left">Vendidos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                    <tr class="border-b border-gray-200 dark:border-gray-600">
                                        <td class="py-4 px-6">{{ $producto->codigo ?? 'N/A' }}</td>
                                        <td class="py-4 px-6">{{ $producto->nombre }}</td>
                                        <td class="py-4 px-6">{{ $producto->categoria->nombre }}</td>
                                        <td class="py-4 px-6">
                                            <span class="@if($producto->stock === 0) text-red-600 @elseif($producto->stock <= 5) text-yellow-600 @else text-green-600 @endif">
                                                {{ $producto->stock }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">${{ number_format($producto->precio_venta, 2) }}</td>
                                        <td class="py-4 px-6">${{ number_format($producto->stock * $producto->precio_venta, 2) }}</td>
                                        <td class="py-4 px-6">{{ $producto->total_vendido }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
