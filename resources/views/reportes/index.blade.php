<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reportes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Reporte de Ventas por Período -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Ventas por Período</h3>
                        <form action="{{ route('reportes.ventas') }}" method="GET" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Fin</label>
                                <input type="date" name="fecha_fin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                Generar Reporte
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Productos más Vendidos -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Productos más Vendidos</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Ver el top 10 de productos más vendidos.</p>
                        <a href="{{ route('reportes.productos-populares') }}" class="block w-full bg-green-500 text-white text-center px-4 py-2 rounded-md hover:bg-green-600">
                            Ver Reporte
                        </a>
                    </div>
                </div>

                <!-- Ventas por Vendedor -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Ventas por Vendedor</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Análisis de ventas por cada vendedor.</p>
                        <a href="{{ route('reportes.vendedores') }}" class="block w-full bg-purple-500 text-white text-center px-4 py-2 rounded-md hover:bg-purple-600">
                            Ver Reporte
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
