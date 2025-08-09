<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ajuste de Stock') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Stock Actual y Ajustes</h3>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-700">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 text-left">Código</th>
                                    <th class="py-3 px-6 text-left">Producto</th>
                                    <th class="py-3 px-6 text-left">Categoría</th>
                                    <th class="py-3 px-6 text-left">Stock Actual</th>
                                    <th class="py-3 px-6 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                    <tr class="border-b border-gray-200 dark:border-gray-600">
                                        <td class="py-4 px-6">{{ $producto->codigo ?? 'N/A' }}</td>
                                        <td class="py-4 px-6">{{ $producto->nombre }}</td>
                                        <td class="py-4 px-6">{{ $producto->categoria->nombre }}</td>
                                        <td class="py-4 px-6">
                                            <span class="@if($producto->stock === 0) text-red-600 @elseif($producto->stock <= 5) text-yellow-600 @else text-gray-900 dark:text-gray-300 @endif">
                                                {{ $producto->stock }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <button onclick="openAjusteModal({{ $producto->id }}, '{{ $producto->nombre }}')"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                Ajustar Stock
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Ajuste -->
    <div id="modal-ajuste" class="fixed inset-0 bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4" id="modal-title"></h3>

                    <form action="{{ route('productos.ajustar-stock') }}" method="POST">
                        @csrf
                        <input type="hidden" name="producto_id" id="producto_id">

                        <div class="mb-4">
                            <label for="tipo_ajuste" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Ajuste</label>
                            <select name="tipo_ajuste" id="tipo_ajuste" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="sumar">Sumar al stock</option>
                                <option value="restar">Restar del stock</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="cantidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" min="1" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="motivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Motivo del Ajuste</label>
                            <textarea name="motivo" id="motivo" rows="2" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" onclick="closeAjusteModal()"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                                Guardar Ajuste
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openAjusteModal(productoId, nombre) {
            document.getElementById('modal-title').textContent = `Ajustar Stock - ${nombre}`;
            document.getElementById('producto_id').value = productoId;
            document.getElementById('modal-ajuste').classList.remove('hidden');
        }

        function closeAjusteModal() {
            document.getElementById('modal-ajuste').classList.add('hidden');
            document.getElementById('producto_id').value = '';
            document.getElementById('cantidad').value = '';
            document.getElementById('motivo').value = '';
            document.getElementById('tipo_ajuste').selectedIndex = 0;
        }
    </script>
</x-app-layout>
