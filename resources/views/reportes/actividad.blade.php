<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Reporte de Actividad') }}
            </h2>
            <div class="flex space-x-2">
                <button onclick="window.print()"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                    Imprimir
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Actividad de Usuarios -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Actividad por Usuario</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-700">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 text-left">Usuario</th>
                                    <th class="py-3 px-6 text-left">Rol</th>
                                    <th class="py-3 px-6 text-left">Ventas Realizadas</th>
                                    <th class="py-3 px-6 text-left">Total Vendido</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($actividad as $registro)
                                    <tr class="border-b border-gray-200 dark:border-gray-600">
                                        <td class="py-4 px-6">{{ $registro->name }}</td>
                                        <td class="py-4 px-6">
                                            @php
                                                $user = $usuarios->firstWhere('name', $registro->name);
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($user->role === 'admin') bg-purple-100 text-purple-800
                                                @elseif($user->role === 'vendedor') bg-blue-100 text-blue-800
                                                @elseif($user->role === 'inventario') bg-green-100 text-green-800
                                                @elseif($user->role === 'compras') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">{{ $registro->total_ventas }}</td>
                                        <td class="py-4 px-6">${{ number_format($registro->total_vendido, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Gráfico o Estadísticas Adicionales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Distribución por Roles</h3>
                        <div class="space-y-4">
                            @php
                                $roleCount = $usuarios->groupBy('role')->map->count();
                            @endphp
                            @foreach($roleCount as $role => $count)
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span>{{ ucfirst($role) }}</span>
                                        <span>{{ $count }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="h-2.5 rounded-full
                                            @if($role === 'admin') bg-purple-600
                                            @elseif($role === 'vendedor') bg-blue-600
                                            @elseif($role === 'inventario') bg-green-600
                                            @elseif($role === 'compras') bg-yellow-600
                                            @else bg-gray-600 @endif"
                                            style="width: {{ ($count / $usuarios->count() * 100) }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg md:col-span-2">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Rendimiento de Ventas</h3>
                        <div class="space-y-4">
                            @foreach($actividad->sortByDesc('total_vendido')->take(5) as $registro)
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span>{{ $registro->name }}</span>
                                        <span>${{ number_format($registro->total_vendido, 2) }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="bg-blue-600 h-2.5 rounded-full"
                                            style="width: {{ ($registro->total_vendido / $actividad->max('total_vendido') * 100) }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
