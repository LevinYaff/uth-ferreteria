<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Compra #' . $compra->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 dark:bg-red-800 dark:text-red-200" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('compras.update', $compra->id) }}" enctype="multipart/form-data" id="formularioCompra">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <!-- Proveedor -->
                            <div>
                                <label for="proveedor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Proveedor</label>
                                <select name="proveedor_id" id="proveedor_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Seleccione un proveedor</option>
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}" {{ old('proveedor_id', $compra->proveedor_id) == $proveedor->id ? 'selected' : '' }}>
                                            {{ $proveedor->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('proveedor_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Fecha de compra -->
                            <div>
                                <label for="fecha_compra" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de Compra</label>
                                <input type="date" name="fecha_compra" id="fecha_compra" value="{{ old('fecha_compra', $compra->fecha_compra->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>
                                @error('fecha_compra')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Número de factura -->
                            <div>
                                <label for="numero_factura" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número de Factura</label>
                                <input type="text" name="numero_factura" id="numero_factura" value="{{ old('numero_factura', $compra->numero_factura) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('numero_factura')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Número de orden -->
                            <div>
                                <label for="numero_orden" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número de Orden</label>
                                <input type="text" name="numero_orden" id="numero_orden" value="{{ old('numero_orden', $compra->numero_orden) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('numero_orden')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Archivo de factura -->
                            <div>
                                <label for="archivo_factura" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Archivo de Factura</label>
                                @if($compra->archivo_factura)
                                    <div class="mb-2">
                                        <a href="{{ Storage::url($compra->archivo_factura) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                            Ver factura actual
                                        </a>
                                    </div>
                                @endif
                                <input type="file" name="archivo_factura" id="archivo_factura" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Formatos permitidos: PDF, JPG, JPEG, PNG (máx. 2MB)</p>
                                @error('archivo_factura')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Productos -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2">Productos</h3>

                            <!-- Selector de productos -->
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="md:col-span-2">
                                        <label for="producto_select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Producto</label>
                                        <select id="producto_select" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                            <option value="">Seleccione un producto</option>
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}"
                                                        data-nombre="{{ $producto->nombre }}"
                                                        data-codigo="{{ $producto->codigo }}"
                                                        data-precio="{{ $producto->precio_compra }}">
                                                    {{ $producto->nombre }} ({{ $producto->codigo ?? 'Sin código' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="cantidad_select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cantidad</label>
                                        <input type="number" id="cantidad_select" min="1" value="1" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    </div>

                                    <div>
                                        <label for="precio_select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Precio Unitario</label>
                                        <input type="number" id="precio_select" min="0.01" step="0.01" value="0.01" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <button type="button" id="agregar_producto" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Agregar Producto
                                    </button>
                                </div>
                            </div>

                            <!-- Tabla de productos seleccionados -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-700">
                                    <thead>
                                        <tr>
                                            <th class="py-3 px-6 text-left">Producto</th>
                                            <th class="py-3 px-6 text-left">Cantidad</th>
                                            <th class="py-3 px-6 text-left">Precio Unitario</th>
                                            <th class="py-3 px-6 text-left">Subtotal</th>
                                            <th class="py-3 px-6 text-left">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla_productos">
                                        <tr id="no_productos" style="display: {{ $compra->detalles->count() > 0 ? 'none' : '' }}">
                                            <td colspan="5" class="py-4 px-6 text-center">No hay productos agregados</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="py-3 px-6 text-right font-semibold">Subtotal:</td>
                                            <td class="py-3 px-6 font-semibold" id="subtotal_compra">$0.00</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="py-3 px-6 text-right font-semibold">Impuestos:</td>
                                            <td class="py-3 px-6">
                                                <input type="number" name="impuestos" id="impuestos" min="0" step="0.01" value="{{ old('impuestos', $compra->impuestos) }}" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="py-3 px-6 text-right font-semibold">Descuento:</td>
                                            <td class="py-3 px-6">
                                                <input type="number" name="descuento" id="descuento" min="0" step="0.01" value="{{ old('descuento', $compra->descuento) }}" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="py-3 px-6 text-right font-semibold">Total:</td>
                                            <td class="py-3 px-6 font-semibold" id="total_compra">$0.00</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="mb-6">
                            <label for="observaciones" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('observaciones', $compra->observaciones) }}</textarea>
                            @error('observaciones')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('compras.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 mr-4">
                                Cancelar
                            </a>
                            <button type="submit" id="guardar_compra" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Actualizar Compra
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let productos = [];
            let contador = 0;
            const tablaProductos = document.getElementById('tabla_productos');
            const noProductos = document.getElementById('no_productos');
            const subtotalCompra = document.getElementById('subtotal_compra');
            const totalCompra = document.getElementById('total_compra');
            const impuestosInput = document.getElementById('impuestos');
            const descuentoInput = document.getElementById('descuento');
            const formularioCompra = document.getElementById('formularioCompra');

            // Cargar productos existentes
            @foreach($compra->detalles as $detalle)
                agregarProductoExistente({
                    id: '{{ $detalle->producto_id }}',
                    nombre: '{{ $detalle->producto->nombre }}',
                    codigo: '{{ $detalle->producto->codigo }}',
                    cantidad: {{ $detalle->cantidad }},
                    precio: {{ $detalle->precio_unitario }},
                    subtotal: {{ $detalle->subtotal }}
                });
            @endforeach

            function agregarProductoExistente(producto) {
                productos.push({
                    id: producto.id,
                    nombre: producto.nombre,
                    codigo: producto.codigo,
                    cantidad: producto.cantidad,
                    precio: producto.precio,
                    subtotal: producto.subtotal,
                    indice: contador
                });

                const fila = document.createElement('tr');
                fila.id = `producto_${contador}`;
                fila.className = 'border-b border-gray-200 dark:border-gray-600';
                fila.innerHTML = `
                    <td class="py-4 px-6">${producto.nombre} ${producto.codigo ? `(${producto.codigo})` : ''}</td>
                    <td class="py-4 px-6">${producto.cantidad}</td>
                    <td class="py-4 px-6">$${producto.precio.toFixed(2)}</td>
                    <td class="py-4 px-6">$${producto.subtotal.toFixed(2)}</td>
                    <td class="py-4 px-6">
                        <button type="button" class="text-red-600 hover:text-red-900" onclick="eliminarProducto(${contador})">
                            Eliminar
                        </button>
                    </td>
                    <input type="hidden" name="productos[${contador}][id]" value="${producto.id}">
                    <input type="hidden" name="productos[${contador}][cantidad]" value="${producto.cantidad}">
                    <input type="hidden" name="productos[${contador}][precio]" value="${producto.precio}">
                `;

                tablaProductos.appendChild(fila);
                contador++;
                actualizarTotales();
            }

            // Evento para agregar producto
            document.getElementById('agregar_producto').addEventListener('click', function() {
                const productoSelect = document.getElementById('producto_select');
                const cantidadInput = document.getElementById('cantidad_select');
                const precioInput = document.getElementById('precio_select');

                const productoId = productoSelect.value;
                if (!productoId) {
                    alert('Por favor seleccione un producto');
                    return;
                }

                const cantidad = parseInt(cantidadInput.value);
                if (isNaN(cantidad) || cantidad <= 0) {
                    alert('La cantidad debe ser un número positivo');
                    return;
                }

                const precio = parseFloat(precioInput.value);
                if (isNaN(precio) || precio <= 0) {
                    alert('El precio debe ser un número positivo');
                    return;
                }

                const option = productoSelect.options[productoSelect.selectedIndex];
                const nombre = option.dataset.nombre;
                const codigo = option.dataset.codigo;

                // Verificar si el producto ya está en la lista
                const productoExistente = productos.find(p => p.id === productoId);
                if (productoExistente) {
                    alert('Este producto ya está en la lista');
                    return;
                }

                // Agregar el nuevo producto
                agregarProductoExistente({
                    id: productoId,
                    nombre: nombre,
                    codigo: codigo,
                    cantidad: cantidad,
                    precio: precio,
                    subtotal: cantidad * precio
                });

                // Ocultar mensaje de no productos
                if (noProductos) {
                    noProductos.style.display = 'none';
                }

                // Limpiar selección
                productoSelect.value = '';
                cantidadInput.value = '1';
                precioInput.value = '0.00';
            });

            // Cargar precio al seleccionar producto
            document.getElementById('producto_select').addEventListener('change', function() {
                const option = this.options[this.selectedIndex];
                if (option && option.dataset.precio) {
                    document.getElementById('precio_select').value = option.dataset.precio;
                } else {
                    document.getElementById('precio_select').value = '0.01';
                }
            });

            // Actualizar totales cuando cambian impuestos o descuento
            impuestosInput.addEventListener('change', actualizarTotales);
            descuentoInput.addEventListener('change', actualizarTotales);

            // Función para eliminar producto
            window.eliminarProducto = function(indice) {
                productos = productos.filter(p => p.indice !== indice);
                const fila = document.getElementById(`producto_${indice}`);
                if (fila) {
                    fila.remove();
                }

                if (productos.length === 0) {
                    noProductos.style.display = '';
                }

                actualizarTotales();
            };

            // Función para actualizar totales
            function actualizarTotales() {
                let subtotal = productos.reduce((sum, p) => sum + p.subtotal, 0);
                let impuestos = parseFloat(impuestosInput.value) || 0;
                let descuento = parseFloat(descuentoInput.value) || 0;
                let total = subtotal + impuestos - descuento;

                subtotalCompra.textContent = `$${subtotal.toFixed(2)}`;
                totalCompra.textContent = `$${total.toFixed(2)}`;
            }

            // Limpiar campos del selector de productos cuando se pierde el foco
            document.getElementById('producto_select').addEventListener('blur', function() {
                if (!this.value) {
                    document.getElementById('precio_select').value = '0.00';
                    document.getElementById('cantidad_select').value = '1';
                }
            });

            // Validar formulario antes de enviar
            formularioCompra.addEventListener('submit', function(e) {
                // Solo validar que haya al menos un producto en la tabla
                if (productos.length === 0) {
                    e.preventDefault();
                    alert('Debe agregar al menos un producto a la compra');
                    return;
                }
            });

            // Inicializar totales
            actualizarTotales();
        });
    </script>
</x-app-layout>
