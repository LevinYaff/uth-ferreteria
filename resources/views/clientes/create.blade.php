<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar Nuevo Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('clientes.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="nombre"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                    required>
                                @error('nombre')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="apellido"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
                                <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('apellido')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="tipo_documento"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de
                                    Documento</label>
                                <select name="tipo_documento" id="tipo_documento"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    <option value="">Seleccione...</option>
                                    <option value="DNI" {{ old('tipo_documento') == 'DNI' ? 'selected' : '' }}>DNI
                                    </option>
                                    <option value="Pasaporte"
                                        {{ old('tipo_documento') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                    <option value="Cédula" {{ old('tipo_documento') == 'Cédula' ? 'selected' : '' }}>
                                        Cédula</option>
                                    <option value="RUT" {{ old('tipo_documento') == 'RUT' ? 'selected' : '' }}>RUT
                                    </option>
                                    <option value="Otro" {{ old('tipo_documento') == 'Otro' ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                                @error('tipo_documento')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="documento"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número de
                                    Documento</label>
                                <input type="text" name="documento" id="documento" value="{{ old('documento') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('documento')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="fecha_nacimiento"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de
                                    Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                                    value="{{ old('fecha_nacimiento') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('fecha_nacimiento')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="telefono"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('telefono')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @error('email')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="direccion"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dirección</label>
                            <textarea name="direccion" id="direccion" rows="2"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="ciudad"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ciudad</label>
                                <input type="text" name="ciudad" id="ciudad" value="{{ old('ciudad') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">

                                <div>
                                    <label for="ciudad"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ciudad</label>
                                    <input type="text" name="ciudad" id="ciudad" value="{{ old('ciudad') }}"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    @error('ciudad')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="estado"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado/Provincia</label>
                                    <input type="text" name="estado" id="estado" value="{{ old('estado') }}"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    @error('estado')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="codigo_postal"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código
                                        Postal</label>
                                    <input type="text" name="codigo_postal" id="codigo_postal"
                                        value="{{ old('codigo_postal') }}"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                    @error('codigo_postal')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ubicación
                                    en el Mapa</label>
                                <div id="mapa" class="h-96 w-full rounded-md mb-2"></div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Haz clic en el mapa para marcar la
                                    ubicación del cliente</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                    <div>
                                        <label for="latitud"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Latitud</label>
                                        <input type="text" name="latitud" id="latitud"
                                            value="{{ old('latitud') }}"
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                            readonly>
                                    </div>
                                    <div>
                                        <label for="longitud"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Longitud</label>
                                        <input type="text" name="longitud" id="longitud"
                                            value="{{ old('longitud') }}"
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="notas"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notas</label>
                                <textarea name="notas" id="notas" rows="3"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('notas') }}</textarea>
                                @error('notas')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a href="{{ route('clientes.index') }}"
                                    class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 mr-4">
                                    Cancelar
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Guardar Cliente
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir Leaflet para el mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar mapa centrado en una ubicación predeterminada
            const map = L.map('mapa').setView([15.5, -88.0], 13); // Coordenadas de ejemplo para Honduras

            // Añadir capa de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            let marker = null;

            // Manejar clics en el mapa
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                // Actualizar campos de latitud y longitud
                document.getElementById('latitud').value = lat;
                document.getElementById('longitud').value = lng;

                // Actualizar marcador
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
            });

            // Si ya hay coordenadas (al editar), mostrar el marcador
            const latInput = document.getElementById('latitud');
            const lngInput = document.getElementById('longitud');

            if (latInput.value && lngInput.value) {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                const latlng = L.latLng(lat, lng);

                marker = L.marker(latlng).addTo(map);
                map.setView(latlng, 15);
            }

            // Usar la API de geolocalización para centrar el mapa en la ubicación actual
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 15);
                });
            }

            // Intentar obtener ubicación a partir de la dirección cuando se complete
            const direccionInput = document.getElementById('direccion');
            const ciudadInput = document.getElementById('ciudad');
            const estadoInput = document.getElementById('estado');

            ciudadInput.addEventListener('blur', geocodeAddress);

            function geocodeAddress() {
                const direccion = direccionInput.value;
                const ciudad = ciudadInput.value;
                const estado = estadoInput.value;

                if (direccion && ciudad) {
                    const query = `${direccion}, ${ciudad}, ${estado || ''}`;

                    // Usar la API de Nominatim para geocodificación (límite de uso: respeta los términos)
                    fetch(
                            `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                const lat = parseFloat(data[0].lat);
                                const lng = parseFloat(data[0].lon);

                                // Actualizar campos y mapa solo si no se han establecido manualmente
                                if (!latInput.value || !lngInput.value) {
                                    latInput.value = lat;
                                    lngInput.value = lng;

                                    const latlng = L.latLng(lat, lng);

                                    if (marker) {
                                        marker.setLatLng(latlng);
                                    } else {
                                        marker = L.marker(latlng).addTo(map);
                                    }

                                    map.setView(latlng, 15);
                                }
                            }
                        })
                        .catch(error => console.error('Error geocodificando dirección:', error));
                }
            }
        });
    </script>
</x-app-layout>
