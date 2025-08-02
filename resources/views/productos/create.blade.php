<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="nombre"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('nombre')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="codigo"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código</label>
                                <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('codigo')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="descripcion"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="categoria_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                            <select name="categoria_id" id="categoria_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">Seleccione una categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}"
                                        {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="precio_compra"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio de
                                    Compra</label>
                                <input type="number" step="0.01" name="precio_compra" id="precio_compra"
                                    value="{{ old('precio_compra') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('precio_compra')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="precio_venta"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio de
                                    Venta</label>
                                <input type="number" step="0.01" name="precio_venta" id="precio_venta"
                                    value="{{ old('precio_venta') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('precio_venta')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="stock"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('stock')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="imagen"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen</label>
                            <input type="file" name="imagen" id="imagen"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            @error('imagen')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="activo" value="1"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    {{ old('activo', '1') == '1' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Activo</span>
                            </label>
                        </div>

                        <!-- Asociación con proveedores -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proveedores</label>
                            <div class="mt-2 bg-gray-50 dark:bg-gray-800 p-4 rounded-md">
                                <div class="mb-2">
                                    <label class="text-sm text-gray-600 dark:text-gray-400">
                                        Seleccione los proveedores que suministran este producto:
                                    </label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($proveedores as $proveedor)
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="proveedor_{{ $proveedor->id }}" name="proveedores[]"
                                                    type="checkbox" value="{{ $proveedor->id }}"
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                    {{ in_array($proveedor->id, old('proveedores', [])) ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="proveedor_{{ $proveedor->id }}"
                                                    class="font-medium text-gray-700 dark:text-gray-300">{{ $proveedor->nombre }}</label>
                                                <p class="text-gray-500 dark:text-gray-400">
                                                    {{ $proveedor->contacto ?? 'Sin contacto' }} -
                                                    {{ $proveedor->telefono }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4">
                                    <label for="proveedor_principal"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proveedor
                                        Principal</label>
                                    <select name="proveedor_principal" id="proveedor_principal"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                        <option value="">Seleccione el proveedor principal</option>
                                        @foreach ($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}"
                                                {{ old('proveedor_principal') == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        El proveedor principal se utilizará por defecto para compras automáticas.
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="flex items-center justify-between mt-4">
                            <a href="{{ route('productos.index') }}"
                                class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Cancelar</a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
