<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar Venta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('ventas.store') }}" id="formVenta">
                        @csrf


                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Información de la Venta</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="cliente_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cliente</label>
                                    <select name="cliente_id" id="cliente_id"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                        <option value="">Sin cliente (venta anónima)</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}"
                                                {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nombre_completo }}
                                                {{ $cliente->documento ? '(' . $cliente->documento . ')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="mt-1 text-sm">
                                        <a href="{{ route('clientes.create') }}"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                            target="_blank">
                                            + Crear nuevo cliente
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    <label for="metodo_pago"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Método
                                        de Pago</label>
                                    <select name="metodo_pago" id="metodo_pago"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                        <option value="Efectivo"
                                            {{ old('metodo_pago') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                                        <option value="Tarjeta de Crédito"
                                            {{ old('metodo_pago') == 'Tarjeta de Crédito' ? 'selected' : '' }}>Tarjeta
                                            de Crédito</option>
                                        <option value="Tarjeta de Débito"
                                            {{ old('metodo_pago') == 'Tarjeta de Débito' ? 'selected' : '' }}>Tarjeta
                                            de Débito</option>
                                        <option value="Transferencia Bancaria"
                                            {{ old('metodo_pago') == 'Transferencia Bancaria' ? 'selected' : '' }}>
                                            Transferencia Bancaria</option>
                                        <option value="Otro" {{ old('metodo_pago') == 'Otro' ? 'selected' : '' }}>
                                            Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Productos</h3>

                            <div class="overflow-x-auto mb-4">
                                <table class="min-w-full bg-white dark:bg-gray-700" id="tablaProductos">
                                    <thead>
                                        <tr>
                                            <th class="py-3 px-6 text-left">Producto</th>
                                            <th class="py-3 px-6 text-left">Precio</th>
                                            <th class="py-3 px-6 text-left">Cantidad</th>
                                            <th class="py-3 px-6 text-left">Subtotal</th>
                                            <th class="py-3 px-6 text-left">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detallesVenta">
                                        <!-- Aquí se agregarán dinámicamente las filas de productos -->
                                        <tr id="filaVacia">
                                            <td colspan="5" class="py-4 px-6 text-center">Agregue productos a la
                                                venta</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="py-3 px-6 text-right font-bold">Total:</td>
                                            <td class="py-3 px-6 font-bold" id="totalVenta">$0.00</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                                <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Agregar Producto
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="md:col-span-2">
                                        <label for="producto_id"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Producto</label>
                                        <select id="producto_id"
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                            <option value="">Seleccione un producto</option>
                                            @foreach ($productos as $producto)
                                                <option value="{{ $producto->id }}"
                                                    data-precio="{{ $producto->precio_venta }}"
                                                    data-stock="{{ $producto->stock }}"
                                                    data-nombre="{{ $producto->nombre }}">
                                                    {{ $producto->nombre }} -
                                                    ${{ number_format($producto->precio_venta, 2) }} (Stock:
                                                    {{ $producto->stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="cantidad"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                                        <input type="number" id="cantidad" min="1" value="1"
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" id="btnAgregarProducto"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="observaciones"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" rows="2"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <a href="{{ route('ventas.index') }}"
                                class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Cancelar</a>
                            <button type="submit" id="btnGuardarVenta"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
                                disabled>
                                Registrar Venta
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
            let total = 0;

            // Referencias a elementos DOM
            const btnAgregarProducto = document.getElementById('btnAgregarProducto');
            const btnGuardarVenta = document.getElementById('btnGuardarVenta');
            const selectProducto = document.getElementById('producto_id');
            const inputCantidad = document.getElementById('cantidad');
            const detallesVenta = document.getElementById('detallesVenta');
            const filaVacia = document.getElementById('filaVacia');
            const totalVentaElement = document.getElementById('totalVenta');
            const formVenta = document.getElementById('formVenta');

            // Función para actualizar el total
            function actualizarTotal() {
                total = productos.reduce((sum, p) => sum + (p.precio * p.cantidad), 0);
                totalVentaElement.textContent = '$' + total.toFixed(2);

                // Habilitar/deshabilitar botón de guardar
                btnGuardarVenta.disabled = productos.length === 0;
            }

            // Función para agregar producto a la venta
            btnAgregarProducto.addEventListener('click', function() {
                const productoId = selectProducto.value;
                if (!productoId) {
                    alert('Por favor seleccione un producto');
                    return;
                }

                const cantidad = parseInt(inputCantidad.value);
                if (isNaN(cantidad) || cantidad <= 0) {
                    alert('La cantidad debe ser un número positivo');
                    return;
                }

                const option = selectProducto.options[selectProducto.selectedIndex];
                const precio = parseFloat(option.dataset.precio);
                const stock = parseInt(option.dataset.stock);
                const nombre = option.dataset.nombre;

                if (cantidad > stock) {
                    alert(`Stock insuficiente. Disponible: ${stock}`);
                    return;
                }

                // Verificar si el producto ya está en la lista
                const productoExistente = productos.find(p => p.id === productoId);
                if (productoExistente) {
                    if (productoExistente.cantidad + cantidad > stock) {
                        alert(
                            `Stock insuficiente. Ya has agregado ${productoExistente.cantidad} unidades y solo hay ${stock} disponibles.`);
                        return;
                    }
                    productoExistente.cantidad += cantidad;
                    productoExistente.subtotal = productoExistente.precio * productoExistente.cantidad;

                    // Actualizar la fila existente
                    const fila = document.getElementById(`producto-${productoId}`);
                    fila.querySelector('.cantidad').textContent = productoExistente.cantidad;
                    fila.querySelector('.subtotal').textContent = '$' + productoExistente.subtotal.toFixed(
                        2);
                } else {
                    // Agregar nuevo producto
                    const subtotal = precio * cantidad;
                    const nuevoProducto = {
                        id: productoId,
                        nombre: nombre,
                        precio: precio,
                        cantidad: cantidad,
                        subtotal: subtotal
                    };
                    productos.push(nuevoProducto);

                    // Ocultar fila vacía si es necesario
                    if (filaVacia.style.display !== 'none') {
                        filaVacia.style.display = 'none';
                    }

                    // Crear nueva fila
                    const nuevaFila = document.createElement('tr');
                    nuevaFila.id = `producto-${productoId}`;
                    nuevaFila.className = 'border-b border-gray-200 dark:border-gray-600';
                    nuevaFila.innerHTML = `
                        <td class="py-4 px-6">${nombre}</td>
                        <td class="py-4 px-6">$${precio.toFixed(2)}</td>
                        <td class="py-4 px-6 cantidad">${cantidad}</td>
                        <td class="py-4 px-6 subtotal">$${subtotal.toFixed(2)}</td>
                        <td class="py-4 px-6">
                            <button type="button" class="text-red-600 hover:text-red-900" onclick="eliminarProducto('${productoId}')">
                                Eliminar
                            </button>
                        </td>
                        <input type="hidden" name="productos[${productos.length - 1}][id]" value="${productoId}">
                        <input type="hidden" name="productos[${productos.length - 1}][cantidad]" value="${cantidad}">
                    `;
                    detallesVenta.appendChild(nuevaFila);
                }

                // Actualizar total
                actualizarTotal();

                // Limpiar selección
                selectProducto.value = '';
                inputCantidad.value = 1;
            });

            // Función para eliminar producto
            window.eliminarProducto = function(productoId) {
                productos = productos.filter(p => p.id !== productoId);
                const fila = document.getElementById(`producto-${productoId}`);
                fila.remove();

                // Mostrar fila vacía si no hay productos
                if (productos.length === 0) {
                    filaVacia.style.display = '';
                }

                // Actualizar índices de los inputs hidden
                const filas = detallesVenta.querySelectorAll('tr:not(#filaVacia)');
                filas.forEach((fila, index) => {
                    const inputs = fila.querySelectorAll('input[type="hidden"]');
                    inputs.forEach(input => {
                        const name = input.name;
                        input.name = name.replace(/productos\[\d+\]/, `productos[${index}]`);
                    });
                });

                // Actualizar total
                actualizarTotal();
            };

            // Validar formulario antes de enviar
            formVenta.addEventListener('submit', function(e) {
                if (productos.length === 0) {
                    e.preventDefault();
                    alert('Debe agregar al menos un producto a la venta');
                }
            });
        });
    </script>
</x-app-layout>
