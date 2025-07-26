<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalles de Venta #') . $venta->id }}
            </h2>
            <a href="{{ route('ventas.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Volver a Ventas
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                    {{ session('info') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Información de la Venta -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Información de la Venta</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Número de Venta</p>
                            <p class="font-medium">#{{ $venta->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Fecha y Hora</p>
                            <p class="font-medium">{{ $venta->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Vendedor</p>
                            <p class="font-medium">{{ $venta->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Estado</p>
                            <p class="font-medium">
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
                            </p>
                        </div>
                    </div>

                    @if ($venta->observaciones)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Observaciones</p>
                            <p class="font-medium">{{ $venta->observaciones }}</p>
                        </div>
                    @endif

                    @if ($venta->estado === 'completada')
                        <div class="mt-4">
                            <form action="{{ route('ventas.cancelar', $venta->id) }}" method="POST"
                                onsubmit="return confirm('¿Está seguro de que desea cancelar esta venta? Esta acción restaurará el stock de productos.')">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cancelar Venta
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detalles de la Venta -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Productos</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 border dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="py-3 px-6 text-left">Producto</th>
                                    <th class="py-3 px-6 text-left">Precio Unitario</th>
                                    <th class="py-3 px-6 text-left">Cantidad</th>
                                    <th class="py-3 px-6 text-left">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($venta->detalles as $detalle)
                                    <tr class="border-t border-gray-200 dark:border-gray-700">
                                        <td class="py-4 px-6">{{ $detalle->producto->nombre }}</td>
                                        <td class="py-4 px-6">${{ number_format($detalle->precio_unitario, 2) }}</td>
                                        <td class="py-4 px-6">{{ $detalle->cantidad }}</td>
                                        <td class="py-4 px-6">${{ number_format($detalle->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="py-3 px-6 text-right font-bold">Total:</td>
                                    <td class="py-3 px-6 font-bold">${{ number_format($venta->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
