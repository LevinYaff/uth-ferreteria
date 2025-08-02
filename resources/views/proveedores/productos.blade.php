<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Productos del Proveedor: ') . $proveedor->nombre }}
            </h2>
            <a href="{{ route('proveedores.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Volver a Proveedores
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 dark:bg-green-800 dark:text-green-200" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Información del Proveedor -->
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-lg font-medium mb-2">Información del Proveedor</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Contacto:</p>
                                <p class="font-medium">{{ $proveedor->contacto }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Teléfono:</p>
                                <p class="font-medium">{{ $proveedor->telefono }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Email:</p>
                                <p class="font-medium">{{ $proveedor->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Productos -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 border dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="py-3 px-6 text-left">Código</th>
                                    <th class="py-3 px-6 text-left">Nombre</th>
                                    <th class="py-3 px-6 text-left">Categoría</th>
                                    <th class="py-3 px-6 text-left">Precio Compra</th>
                                    <th class="py-3 px-6 text-left">Stock</th>
                                    <th class="py-3 px-6 text-left">Estado</th>
                                    <th class="py-3 px-6 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productos as $producto)
                                    <tr class="border-b border-gray-200 dark:border-gray-600">
                                        <td class="py-4 px-6">{{ $producto->codigo }}</td>
                                        <td class="py-4 px-6">{{ $producto->nombre }}</td>
                                        <td class="py-4 px-6">{{ $producto->categoria->nombre }}</td>
                                        <td class="py-4 px-6">${{ number_format($producto->precio_compra, 2) }}</td>
                                        <td class="py-4 px-6">{{ $producto->stock }}</td>
                                        <td class="py-4 px-6">
                                            @if($producto->activo)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Activo
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inactivo
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            <a href="{{ route('productos.edit', $producto->id) }}"
                                                class="text-blue-600 hover:text-blue-900">Ver Detalles</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 px-6 text-center text-gray-500 dark:text-gray-400">
                                            No hay productos asociados a este proveedor
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($productos->hasPages())
                        <div class="mt-4">
                            {{ $productos->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
