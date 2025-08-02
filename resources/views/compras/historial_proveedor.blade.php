<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Historial de Compras - ') . $proveedor->nombre }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('proveedores.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Volver a Proveedores
                </a>
                <a href="{{ route('compras.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Nueva Compra
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Información del proveedor -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Información del Proveedor</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nombre</p>
                            <p class="font-medium">{{ $proveedor->nombre }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Contacto</p>
                            <p class="font-medium">{{ $proveedor->contacto ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Teléfono</p>
                            <p class="font-medium">{{ $proveedor->telefono }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="font-medium">{{ $proveedor->email ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Dirección</p>
                            <p class="font-medium">{{ $proveedor->direccion ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Estado</p>
                            <p class="font-medium">
                                @if ($proveedor->activo)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Activo
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Inactivo
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 flex space-x-2">
                        <a href="{{ route('proveedores.edit', $proveedor->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Editar Proveedor
                        </a>
                        <a href="{{ route('proveedores.productos', $proveedor->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 active:bg-purple-700 focus:outline-none focus:border-purple-700 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Ver Productos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Historial de compras -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Historial de Compras</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-700">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Fecha</th>
                                    <th class="py-3 px-6 text-left">Nº Factura</th>
                                    <th class="py-3 px-6 text-left">Total</th>
                                    <th class="py-3 px-6 text-left">Estado</th>
                                    <th class="py-3 px-6 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($compras as $compra)
                                    <tr class="border-b border-gray-200 dark:border-gray-600">
                                        <td class="py-4 px-6">{{ $compra->id }}</td>
                                        <td class="py-4 px-6">{{ $compra->fecha_compra->format('d/m/Y') }}</td>
                                        <td class="py-4 px-6">{{ $compra->numero_factura ?? 'N/A' }}</td>
                                        <td class="py-4 px-6">${{ number_format($compra->total, 2) }}</td>
                                        <td class="py-4 px-6">
                                            @if ($compra->estado === 'pendiente')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                    Pendiente
                                                </span>
                                            @elseif($compra->estado === 'recibida')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    Recibida
                                                </span>
                                            @elseif($compra->estado === 'parcial')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Parcial
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    Cancelada
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 flex space-x-2">
                                            <a href="{{ route('compras.show', $compra->id) }}"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                Ver
                                            </a>
                                            <a href="{{ route('compras.factura-pdf', $compra->id) }}"
                                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                                target="_blank">
                                                PDF
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 px-6 text-center">No hay compras registradas para
                                            este proveedor</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
