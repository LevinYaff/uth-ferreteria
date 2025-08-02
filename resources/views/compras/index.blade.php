<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Compras') }}
            </h2>
            <a href="{{ route('compras.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Registrar Nueva Compra
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

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 dark:bg-red-800 dark:text-red-200" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-700">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Proveedor</th>
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
                                        <td class="py-4 px-6">{{ $compra->proveedor->nombre }}</td>
                                        <td class="py-4 px-6">{{ $compra->fecha_compra->format('d/m/Y') }}</td>
                                        <td class="py-4 px-6">{{ $compra->numero_factura ?? 'N/A' }}</td>
                                        <td class="py-4 px-6">${{ number_format($compra->total, 2) }}</td>
                                        <td class="py-4 px-6">
                                            @if($compra->estado === 'pendiente')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                    Pendiente
                                                </span>
                                            @elseif($compra->estado === 'recibida')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    Recibida
                                                </span>
                                            @elseif($compra->estado === 'parcial')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Parcial
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    Cancelada
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 flex space-x-2">
                                            <a href="{{ route('compras.show', $compra->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                Ver
                                            </a>
                                            @if($compra->estado === 'pendiente')
                                                <a href="{{ route('compras.edit', $compra->id) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                                    Editar
                                                </a>
                                            @endif
                                            <a href="{{ route('compras.factura-pdf', $compra->id) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" target="_blank">
                                                PDF
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 px-6 text-center">No hay compras registradas</td>
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
