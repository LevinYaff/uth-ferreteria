<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ventas') }}
            </h2>
            <a href="{{ route('ventas.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Registrar Nueva Venta
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

                        @if (session('info'))
                            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                                {{ session('info') }}
                            </div>
                        @endif

                        <table class="min-w-full bg-white dark:bg-gray-800 border dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Fecha</th>
                                    <th class="py-3 px-6 text-left">Vendedor</th>
                                    <th class="py-3 px-6 text-left">Total</th>
                                    <th class="py-3 px-6 text-left">Estado</th>
                                    <th class="py-3 px-6 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ventas as $venta)
                                    <tr class="border-t border-gray-200 dark:border-gray-700">
                                        <td class="py-4 px-6">{{ $venta->id }}</td>
                                        <td class="py-4 px-6">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="py-4 px-6">{{ $venta->user->name }}</td>
                                        <td class="py-4 px-6">${{ number_format($venta->total, 2) }}</td>
                                        <td class="py-4 px-6">
                                            @if ($venta->estado === 'completada')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Completada
                                                </span>
                                            @elseif($venta->estado === 'pendiente')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pendiente
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Cancelada
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            <a href="{{ route('ventas.show', $venta->id) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-2">Ver Detalles</a>
                                            <a href="{{ route('ventas.factura-pdf', $venta->id) }}"
                                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                                target="_blank">
                                                Factura
                                            </a>
                                            @if ($venta->estado === 'completada')
                                                <form action="{{ route('ventas.cancelar', $venta->id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                        onclick="return confirm('¿Está seguro de que desea cancelar esta venta? Esta acción devolverá los productos al inventario.')">
                                                        Cancelar
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 px-6 text-center">No hay ventas registradas</td>
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
