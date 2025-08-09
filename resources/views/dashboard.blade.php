<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-2">Ventas Totales</h3>
                        <p class="text-3xl font-bold">${{ number_format($totalVentas, 2) }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-2">Productos</h3>
                        <p class="text-3xl font-bold">{{ $totalProductos }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-2">Productos Agotados</h3>
                        <p class="text-3xl font-bold">{{ $productosAgotados }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-2">Proveedores</h3>
                        <p class="text-3xl font-bold">{{ $totalProveedores }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Ventas recientes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Ventas Recientes</h3>

                        @if ($ventasRecientes->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-800 border dark:border-gray-700">
                                    <thead>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <th class="py-2 px-4 text-left">#</th>
                                            <th class="py-2 px-4 text-left">Fecha</th>
                                            <th class="py-2 px-4 text-left">Vendedor</th>
                                            <th class="py-2 px-4 text-left">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ventasRecientes as $venta)
                                            <tr class="border-t border-gray-200 dark:border-gray-700">

                                                <td class="py-2 px-4">
                                                    <a href="{{ route('ventas.show', $venta->id) }}"
                                                        class="text-blue-600 hover:text-blue-900">
                                                        #{{ $venta->id }}
                                                    </a>
                                                </td>
                                                <td class="py-2 px-4">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                                <td class="py-2 px-4">{{ $venta->user->name }}</td>
                                                <td class="py-2 px-4">${{ number_format($venta->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('ventas.index') }}" class="text-blue-600 hover:text-blue-900">Ver
                                    todas las ventas →</a>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No hay ventas recientes.</p>
                        @endif
                    </div>
                </div>

                <!-- Productos con bajo stock -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Productos con Bajo Stock</h3>

                        @if ($productosBajoStock->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-800 border dark:border-gray-700">
                                    <thead>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <th class="py-2 px-4 text-left">Producto</th>
                                            <th class="py-2 px-4 text-left">Categoría</th>
                                            <th class="py-2 px-4 text-left">Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productosBajoStock as $producto)
                                            <tr class="border-t border-gray-200 dark:border-gray-700">

                                                <td class="py-2 px-4">
                                                    <a href="{{ route('productos.edit', $producto->id) }}"
                                                        class="text-blue-600 hover:text-blue-900">
                                                        {{ $producto->nombre }}
                                                    </a>
                                                </td>
                                                <td class="py-2 px-4">{{ $producto->categoria->nombre }}</td>
                                                <td class="py-2 px-4">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        {{ $producto->stock }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('productos.index') }}" class="text-blue-600 hover:text-blue-900">Ver
                                    todos los productos →</a>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No hay productos con bajo stock.</p>
                        @endif
                    </div>
                </div>

                <!-- Productos más vendidos -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Productos Más Vendidos</h3>

                        @if ($productosMasVendidos->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-800 border dark:border-gray-700">
                                    <thead>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <th class="py-2 px-4 text-left">Producto</th>
                                            <th class="py-2 px-4 text-left">Unidades Vendidas</th>
                                            <th class="py-2 px-4 text-left">Ingresos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productosMasVendidos as $producto)
                                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                                <td class="py-2 px-4">{{ $producto->nombre }}</td>
                                                <td class="py-2 px-4">{{ $producto->total_vendido }}</td>
                                                <td class="py-2 px-4">
                                                    ${{ number_format($producto->total_ingresos, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No hay datos de ventas disponibles.</p>
                        @endif
                    </div>
                </div>

                <!-- Accesos rápidos -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Acciones Rápidas</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('ventas.create') }}"
                                class="block p-4 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 rounded-lg transition duration-300">
                                <h4 class="text-md font-semibold mb-1">Registrar Venta</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Procesar una nueva venta</p>
                            </a>

                            <a href="{{ route('productos.create') }}"
                                class="block p-4 bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:hover:bg-green-800 rounded-lg transition duration-300">
                                <h4 class="text-md font-semibold mb-1">Nuevo Producto</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Añadir producto al inventario</p>
                            </a>

                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('proveedores.create') }}"
                                    class="block p-4 bg-purple-100 hover:bg-purple-200 dark:bg-purple-900 dark:hover:bg-purple-800 rounded-lg transition duration-300">
                                    <h4 class="text-md font-semibold mb-1">Nuevo Proveedor</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Registrar proveedor</p>
                                </a>

                                <a href="{{ route('categorias.create') }}"
                                    class="block p-4 bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900 dark:hover:bg-yellow-800 rounded-lg transition duration-300">
                                    <h4 class="text-md font-semibold mb-1">Nueva Categoría</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Añadir categoría de productos
                                    </p>
                                </a>
                            @endif

                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('users.index') }}"
                                    class="block p-4 bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-900 dark:hover:bg-indigo-800 rounded-lg transition duration-300">
                                    <h4 class="text-md font-semibold mb-1">Gestionar Usuarios</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Administrar usuarios y roles
                                    </p>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
