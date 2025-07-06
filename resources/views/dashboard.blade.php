<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Sistema de Administración de Ferretería</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('categorias.index') }}" class="block p-6 bg-blue-100 hover:bg-blue-200 rounded-lg transition duration-300">
                            <h4 class="text-lg font-semibold mb-2">Categorías</h4>
                            <p>Administrar categorías de productos</p>
                        </a>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'vendedor']))
                        <a href="{{ route('productos.index') }}" class="block p-6 bg-green-100 hover:bg-green-200 rounded-lg transition duration-300">
                            <h4 class="text-lg font-semibold mb-2">Productos</h4>
                            <p>Gestionar inventario de productos</p>
                        </a>

                        <a href="{{ route('ventas.index') }}" class="block p-6 bg-yellow-100 hover:bg-yellow-200 rounded-lg transition duration-300">
                            <h4 class="text-lg font-semibold mb-2">Ventas</h4>
                            <p>Registrar y consultar ventas</p>
                        </a>
                        @endif

                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('proveedores.index') }}" class="block p-6 bg-purple-100 hover:bg-purple-200 rounded-lg transition duration-300">
                            <h4 class="text-lg font-semibold mb-2">Proveedores</h4>
                            <p>Administrar proveedores</p>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
