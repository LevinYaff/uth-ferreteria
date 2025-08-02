<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle de Compra #') . $compra->id }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('compras.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Volver
                </a>
                @if ($compra->archivo_factura)
                    <a href="{{ route('compras.factura-pdf', $compra->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150"
                        target="_blank">
                        Ver Factura
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 dark:bg-green-800 dark:text-green-200"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 dark:bg-red-800 dark:text-red-200"
                    role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Información de la compra -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Información de la Compra</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Proveedor</p>
                            <p class="font-medium">{{ $compra->proveedor->nombre }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Contacto</p>
                            <p class="font-medium">{{ $compra->proveedor->contacto ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Teléfono</p>
                            <p class="font-medium">{{ $compra->proveedor->telefono }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de Compra</p>
                            <p class="font-medium">{{ $compra->fecha_compra->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Fecha de Recepción</p>
                            <p class="font-medium">
                                {{ $compra->fecha_recepcion ? $compra->fecha_recepcion->format('d/m/Y') : 'Pendiente' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Estado</p>
                            <p class="font-medium">
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
                                        Recibida Parcialmente
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Cancelada
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Número de Factura</p>
                            <p class="font-medium">{{ $compra->numero_factura ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Número de Orden</p>
                            <p class="font-medium">{{ $compra->numero_orden ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Registrado por</p>
                            <p class="font-medium">{{ $compra->user->name }}</p>
                        </div>
                    </div>

                    @if ($compra->observaciones)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Observaciones</p>
                            <p class="font-medium">{{ $compra->observaciones }}</p>
                        </div>
                    @endif

                    @if ($compra->archivo_factura)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Archivo de Factura</p>
                            <p class="font-medium">Disponible</p>
                        </div>
                    @endif

                    <div class="mt-6 flex space-x-2">
                        @if ($compra->estado === 'pendiente')
                            <a href="{{ route('compras.edit', $compra->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Editar
                            </a>
                            <button type="button"
                                onclick="document.getElementById('modal-recibir').classList.remove('hidden')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Recibir Productos
                            </button>
                            <form action="{{ route('compras.cancelar', $compra->id) }}" method="POST"
                                onsubmit="return confirm('¿Está seguro de que desea cancelar esta compra?');">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cancelar Compra
                                </button>
                            </form>
                        @elseif($compra->estado === 'parcial')
                            <button type="button"
                                onclick="document.getElementById('modal-recibir').classList.remove('hidden')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Actualizar Recepción
                            </button>
                            <form action="{{ route('compras.cancelar', $compra->id) }}" method="POST"
                                onsubmit="return confirm('¿Está seguro de que desea cancelar esta compra? Se revertirán las cantidades ya recibidas.');">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cancelar Compra
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detalles de la compra -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Productos</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-700">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 text-left">Producto</th>
                                    <th class="py-3 px-6 text-left">Cantidad</th>
                                    <th class="py-3 px-6 text-left">Recibido</th>
                                    <th class="py-3 px-6 text-left">Precio Unitario</th>
                                    <th class="py-3 px-6 text-left">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compra->detalles as $detalle)
                                    <tr class="border-b border-gray-200 dark:border-gray-600">
                                        <td class="py-4 px-6">{{ $detalle->producto->nombre }}</td>
                                        <td class="py-4 px-6">{{ $detalle->cantidad }}</td>
                                        <td class="py-4 px-6">
                                            {{ $detalle->cantidad_recibida }}
                                            @if ($detalle->cantidad_recibida > 0 && $detalle->cantidad_recibida < $detalle->cantidad)
                                                <span
                                                    class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Parcial
                                                </span>
                                            @elseif($detalle->cantidad_recibida == $detalle->cantidad)
                                                <span
                                                    class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    Completo
                                                </span>
                                            @elseif($compra->estado !== 'pendiente')
                                                <span
                                                    class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    Pendiente
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">${{ number_format($detalle->precio_unitario, 2) }}</td>
                                        <td class="py-4 px-6">${{ number_format($detalle->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="py-3 px-6 text-right font-semibold">Subtotal:</td>
                                    <td class="py-3 px-6 font-semibold">${{ number_format($compra->subtotal, 2) }}</td>
                                </tr>
                                @if ($compra->impuestos > 0)
                                    <tr>
                                        <td colspan="4" class="py-3 px-6 text-right font-semibold">Impuestos:</td>
                                        <td class="py-3 px-6">${{ number_format($compra->impuestos, 2) }}</td>
                                    </tr>
                                @endif
                                @if ($compra->descuento > 0)
                                    <tr>
                                        <td colspan="4" class="py-3 px-6 text-right font-semibold">Descuento:</td>
                                        <td class="py-3 px-6">${{ number_format($compra->descuento, 2) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="4" class="py-3 px-6 text-right font-semibold">Total:</td>
                                    <td class="py-3 px-6 font-semibold">${{ number_format($compra->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de recepción de productos -->
    <div id="modal-recibir" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div
            class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-4xl w-full mx-4 max-h-screen overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Recibir Productos</h3>
                    <button type="button" onclick="document.getElementById('modal-recibir').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('compras.recibir', $compra->id) }}">
                    @csrf

                    <div class="mb-4">
                        <label for="fecha_recepcion"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de
                            Recepción</label>
                        <input type="date" name="fecha_recepcion" id="fecha_recepcion"
                            value="{{ date('Y-m-d') }}"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                            required>
                    </div>

                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full bg-white dark:bg-gray-700">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 text-left">Producto</th>
                                    <th class="py-3 px-6 text-left">Cantidad Ordenada</th>
                                    <th class="py-3 px-6 text-left">Ya Recibido</th>
                                    <th class="py-3 px-6 text-left">Cantidad a Recibir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compra->detalles as $detalle)
                                    <tr class="border-b border-gray-200 dark:border-gray-600">
                                        <td class="py-4 px-6">{{ $detalle->producto->nombre }}</td>
                                        <td class="py-4 px-6">{{ $detalle->cantidad }}</td>
                                        <td class="py-4 px-6">{{ $detalle->cantidad_recibida }}</td>
                                        <td class="py-4 px-6">
                                            <input type="hidden" name="detalles[{{ $loop->index }}][id]"
                                                value="{{ $detalle->id }}">
                                            <input type="number"
                                                name="detalles[{{ $loop->index }}][cantidad_recibida]"
                                                min="0" max="{{ $detalle->cantidad }}"
                                                value="{{ $detalle->cantidad_recibida }}"
                                                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="button"
                            onclick="document.getElementById('modal-recibir').classList.add('hidden')"
                            class="mr-2 inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-900 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:border-gray-400 dark:focus:border-gray-500 focus:ring ring-gray-200 dark:focus:ring-gray-600 disabled:opacity-25 transition ease-in-out duration-150">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Guardar Recepción
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
