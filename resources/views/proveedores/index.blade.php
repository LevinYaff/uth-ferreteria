<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Proveedores') }}
            </h2>
            <a href="{{ route('proveedores.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Crear Nuevo Proveedor
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
                                    <th class="py-3 px-6 text-left">Nombre</th>
                                    <th class="py-3 px-6 text-left">Contacto</th>
                                    <th class="py-3 px-6 text-left">Teléfono</th>
                                    <th class="py-3 px-6 text-left">Email</th>
                                    <th class="py-3 px-6 text-left">Estado</th>
                                    <th class="py-3 px-6 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proveedores as $proveedor)
                                    <tr class="border-t border-gray-200 dark:border-gray-700">
                                        <td class="py-4 px-6">{{ $proveedor->nombre }}</td>
                                        <td class="py-4 px-6">{{ $proveedor->contacto ?? 'N/A' }}</td>
                                        <td class="py-4 px-6">{{ $proveedor->telefono }}</td>
                                        <td class="py-4 px-6">{{ $proveedor->email ?? 'N/A' }}</td>
                                        <td class="py-4 px-6">
                                            @if ($proveedor->activo)
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
                                            <div class="flex space-x-2">
                                                <a href="{{ route('proveedores.edit', $proveedor->id) }}"
                                                    class="text-blue-600 hover:text-blue-900">Editar</a>
                                                <a href="{{ route('proveedores.compras', $proveedor->id) }}"
                                                    class="text-green-600 hover:text-green-900">Historial de Compras</a>
                                                <a href="{{ route('proveedores.productos', $proveedor->id) }}"
                                                    class="text-purple-600 hover:text-purple-900">Productos</a>
                                                <form action="{{ route('proveedores.destroy', $proveedor->id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('¿Está seguro de que desea eliminar este proveedor?')">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 px-6 text-center">No hay proveedores registrados
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
