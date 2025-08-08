<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle de Venta #') . $venta->id }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('ventas.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Volver
                </a>
                <a href="{{ route('ventas.factura-pdf', $venta->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150"
                    target="_blank">
                    Ver Factura
                </a>
            </div>
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

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Información General</p>
                            <p class="font-medium mt-2">Venta #{{ $venta->id }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Fecha y Hora</p>
                            <p class="font-medium">{{ $venta->created_at->format('d/m/Y H:i') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Vendedor</p>
                            <p class="font-medium">{{ $venta->user->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Método de Pago</p>
                            <p class="font-medium">{{ $venta->metodo_pago ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Estado</p>
                            <p class="font-medium">
                                @if ($venta->estado === 'completada')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Completada
                                    </span>
                                @elseif($venta->estado === 'pendiente')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Pendiente
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Cancelada
                                    </span>
                                @endif
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Total</p>
                            <p class="font-medium">${{ number_format($venta->total, 2) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Estado de Entrega</p>
                            <p class="font-medium">
                                @if ($venta->entregado)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Entregado el {{ $venta->fecha_entrega ? $venta->fecha_entrega->format('d/m/Y') : 'N/A' }}
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Pendiente de Entrega
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if ($venta->cliente)
                        <div class="mt-4">
                            <h4 class="text-md font-medium mb-2">Información del Cliente</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Cliente</p>
                                        <p class="font-medium">
                                            <a href="{{ route('clientes.show', $venta->cliente->id) }}"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                {{ $venta->cliente->nombre_completo }}
                                            </a>
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Contacto</p>
                                        <p class="font-medium">{{ $venta->cliente->telefono ?? 'N/A' }}</p>
                                    </div>

                                    <div class="md:col-span-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Dirección</p>
                                        <p class="font-medium">
                                            {{ $venta->cliente->direccion ?? 'N/A' }}
                                            @if ($venta->cliente->latitud && $venta->cliente->longitud)
                                                <a href="{{ route('clientes.mapa', $venta->cliente->id) }}"
                                                    class="ml-2 text-sm text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                                    target="_blank">
                                                    Ver en mapa
                                                </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Estado de entrega -->
                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Estado de Entrega</p>
                                            <p class="font-medium">
                                                @if ($venta->entregado)
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        Entregado
                                                        ({{ $venta->fecha_entrega ? $venta->fecha_entrega->format('d/m/Y') : 'N/A' }})
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                        Pendiente de Entrega
                                                    </span>
                                                @endif
                                            </p>
                                        </div>

                                        @if ($venta->estado === 'completada')
                                            <button type="button"
                                                onclick="document.getElementById('modal-entrega').classList.remove('hidden')"
                                                class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                {{ $venta->entregado ? 'Actualizar Entrega' : 'Marcar como Entregado' }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

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
                        <table class="min-w-full bg-white dark:bg-gray-700">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 text-left">Producto</th>
                                    <th class="py-3 px-6 text-left">Cantidad</th>
                                    <th class="py-3 px-6 text-left">Precio Unitario</th>
                                    <th class="py-3 px-6 text-left">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($venta->detalles as $detalle)
                                    <tr class="border-b border-gray-200 dark:border-gray-600">
                                        <td class="py-4 px-6">{{ $detalle->producto->nombre }}</td>
                                        <td class="py-4 px-6">{{ $detalle->cantidad }}</td>
                                        <td class="py-4 px-6">${{ number_format($detalle->precio_unitario, 2) }}</td>
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
    @if ($venta->cliente)
        <!-- Modal de entrega -->
        <div id="modal-entrega" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-md w-full mx-4">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Estado de Entrega</h3>
                        <button type="button"
                            onclick="document.getElementById('modal-entrega').classList.add('hidden')"
                            class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('ventas.entregar', $venta->id) }}">
                        @csrf

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estado</label>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="entregado" value="1"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        {{ $venta->entregado ? 'checked' : '' }}>
                                    <span class="ml-2">Entregado</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="entregado" value="0"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        {{ !$venta->entregado ? 'checked' : '' }}>
                                    <span class="ml-2">No Entregado</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="fecha_entrega"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de
                                Entrega</label>
                            <input type="date" name="fecha_entrega" id="fecha_entrega"
                                value="{{ $venta->fecha_entrega ? $venta->fecha_entrega->format('Y-m-d') : date('Y-m-d') }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="button"
                                onclick="document.getElementById('modal-entrega').classList.add('hidden')"
                                class="mr-2 inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-900 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:border-gray-400 dark:focus:border-gray-500 focus:ring ring-gray-200 dark:focus:ring-gray-600 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


</x-app-layout>
