<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Productos') }}
            </h2>
            <a href="{{ route('productos.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Crear Nuevo Producto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        @if (session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4"
                                role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="min-w-full bg-white dark:bg-gray-800 border dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="py-3 px-6 text-left">Imagen</th>
                                    <th class="py-3 px-6 text-left">Código</th>
                                    <th class="py-3 px-6 text-left">Nombre</th>
                                    <th class="py-3 px-6 text-left">Categoría</th>
                                    <th class="py-3 px-6 text-left">Precio Venta</th>
                                    <th class="py-3 px-6 text-left">Stock</th>
                                    <th class="py-3 px-6 text-left">Estado</th>
                                    <th class="py-3 px-6 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productos as $producto)
                                    <tr class="border-t border-gray-200 dark:border-gray-700">
                                        <td class="py-4 px-6">{{ $producto->codigo ?? 'N/A' }}</td>
                                        <td class="py-4 px-6">
                                            @if ($producto->imagen)
                                                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen"
                                                    class="w-16 h-16 object-cover rounded">
                                            @else
                                                <span class="text-gray-500">Sin imagen</span>
                                            @endif
                                        </td>

                                        <td class="py-4 px-6">{{ $producto->nombre }}</td>
                                        <td class="py-4 px-6">{{ $producto->categoria->nombre }}</td>
                                        <td class="py-4 px-6">${{ number_format($producto->precio_venta, 2) }}</td>
                                        <td class="py-4 px-6">{{ $producto->stock }}</td>
                                        <td class="py-4 px-6">
                                            @if ($producto->activo)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Activo
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inactivo
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 flex">
                                            <a href="{{ route('productos.edit', $producto->id) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-2">Editar</a>
                                            <form action="{{ route('productos.destroy', $producto->id) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('¿Está seguro de que desea eliminar este producto?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 px-6 text-center">No hay productos registrados
                                        </td>
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
