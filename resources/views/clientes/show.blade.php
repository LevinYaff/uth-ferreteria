<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalles del Cliente: ') . $cliente->nombre_completo }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('clientes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Volver
                </a>
                <a href="{{ route('clientes.edit', $cliente->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 dark:bg-green-800 dark:text-green-200" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Información del cliente -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Información Personal</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nombre Completo</p>
                            <p class="font-medium">{{ $cliente->nombre_completo }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Documento</p>
                            <p class="font-medium">{{ $cliente->tipo_documento ? $cliente->tipo_documento . ': ' : '' }}{{ $cliente->documento ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de Nacimiento</p>
                            <p class="font-medium">{{ $cliente->fecha_nacimiento ? $cliente->fecha_nacimiento->format('d/m/Y') : 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Teléfono</p>
                            <p class="font-medium">{{ $cliente->telefono ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="font-medium">{{ $cliente->email ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Estado</p>
                            <p class="font-medium">
                                @if($cliente->activo)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Inactivo
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <h3 class="text-lg font-medium mt-6 mb-4">Dirección</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Dirección</p>
                            <p class="font-medium">{{ $cliente->direccion ?? 'N/A' }}</p>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Ciudad</p>
                                <p class="font-medium">{{ $cliente->ciudad ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Estado/Provincia</p>
                                <p class="font-medium">{{ $cliente->estado ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Código Postal</p>
                                <p class="font-medium">{{ $cliente->codigo_postal ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($cliente->latitud && $cliente->longitud)
                        <div class="mt-4">
                            <div id="miniMapa" class="h-56 w-full rounded-md"></div>
                            <div class="mt-2 flex justify-end">
                                <a href="{{ route('clientes.mapa', $cliente->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    Ver mapa completo →
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($cliente->notas)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium mb-2">Notas</h3>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                                {{ $cliente->notas }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Estadísticas del cliente -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Estadísticas de Compras</h3>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                <p class="text-sm text-blue-600 dark:text-blue-300">Total de Compras</p>
                                <p class="text-2xl font-bold text-blue-700 dark:text-blue-200">{{ $totalVentas }}</p>
                            </div>

                            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                                <p class="text-sm text-green-600 dark:text-green-300">Total Gastado</p>
                                <p class="text-2xl font-bold text-green-700 dark:text-green-200">${{ number_format($totalGastado, 2) }}</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('clientes.historial', $cliente->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                Ver historial completo de compras →
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Productos Más Comprados</h3>

                        @if(count($productosMasComprados) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-700">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 text-left">Producto</th>
                                            <th class="py-2 px-4 text-left">Cantidad</th>
                                            <th class="py-2 px-4 text-left">Categoría</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($productosMasComprados as $producto)
                                            <tr class="border-b border-gray-200 dark:border-gray-600">
                                                <td class="py-2 px-4">{{ $producto->nombre }}</td>
                                                <td class="py-2 px-4">{{ $producto->total_comprado }}</td>
                                                <td class="py-2 px-4">{{ $producto->categoria->nombre }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Este cliente aún no ha realizado compras.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Ventas recientes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Ventas Recientes</h3>

                    @if(count($ventasRecientes) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-700">
                                <thead>
                                    <tr>
                                        <th class="py-3 px-6 text-left">ID</th>
                                        <th class="py-3 px-6 text-left">Fecha</th>
                                        <th class="py-3 px-6 text-left">Total</th>
                                        <th class="py-3 px-6 text-left">Estado</th>
                                        <th class="py-3 px-6 text-left">Entregado</th>
                                        <th class="py-3 px-6 text-left">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ventasRecientes as $venta)
                                        <tr class="border-b border-gray-200 dark:border-gray-600">
                                            <td class="py-4 px-6">{{ $venta->id }}</td>
                                            <td class="py-4 px-6">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="py-4 px-6">${{ number_format($venta->total, 2) }}</td>
                                            <td class="py-4 px-6">
                                                @if($venta->estado === 'completada')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        Completada
                                                    </span>
                                                @elseif($venta->estado === 'pendiente')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                        Pendiente
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                        Cancelada
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6">
                                                @if($venta->entregado)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        Sí
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                        No
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6">
                                                <a href="{{ route('ventas.show', $venta->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                    Ver Detalles
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Este cliente aún no ha realizado compras.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($cliente->latitud && $cliente->longitud)
        <!-- Incluir Leaflet para el mini mapa -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar mini mapa
                const miniMapa = L.map('miniMapa').setView([{{ $cliente->latitud }}, {{ $cliente->longitud }}], 15);

                // Añadir capa de OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(miniMapa);

                // Añadir marcador
                L.marker([{{ $cliente->latitud }}, {{ $cliente->longitud }}])
                    .addTo(miniMapa)
                    .bindPopup("<strong>{{ $cliente->nombre_completo }}</strong><br>{{ $cliente->direccion }}")
                    .openPopup();

                // Deshabilitar zoom para el mini mapa
                miniMapa.scrollWheelZoom.disable();
            });
        </script>
    @endif
</x-app-layout>
