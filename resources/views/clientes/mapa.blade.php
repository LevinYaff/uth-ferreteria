<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ubicación de ') . $cliente->nombre_completo }}
            </h2>
            <a href="{{ route('clientes.show', $cliente->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Volver a Detalles
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium mb-2">Dirección</h3>
                        <p>{{ $cliente->direccion }}, {{ $cliente->ciudad }}, {{ $cliente->estado }} {{ $cliente->codigo_postal }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-medium mb-2">Coordenadas</h3>
                        <p>Latitud: {{ $cliente->latitud }}, Longitud: {{ $cliente->longitud }}</p>
                    </div>

                    <div id="mapa" class="h-96 w-full rounded-md"></div>

                    <div class="mt-4">
                        <button id="btnRuta" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Obtener Ruta hasta aquí
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir Leaflet para el mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Leaflet Routing Machine para rutas -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

   <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar mapa
            const map = L.map('mapa').setView([{{ $cliente->latitud }}, {{ $cliente->longitud }}], 15);

            // Añadir capa de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Añadir marcador del cliente
            const clienteMarker = L.marker([{{ $cliente->latitud }}, {{ $cliente->longitud }}])
                .addTo(map)
                .bindPopup("<strong>{{ $cliente->nombre_completo }}</strong><br>{{ $cliente->direccion }}")
                .openPopup();

            // Crear variable para el control de ruta
            let routingControl = null;

            // Botón para obtener ruta
            document.getElementById('btnRuta').addEventListener('click', function() {
                // Si ya hay una ruta, eliminarla
                if (routingControl) {
                    map.removeControl(routingControl);
                    routingControl = null;
                    this.textContent = 'Obtener Ruta hasta aquí';
                    return;
                }

                // Intentar obtener la ubicación actual
                if (navigator.geolocation) {
                    this.textContent = 'Calculando...';

                    navigator.geolocation.getCurrentPosition(
                        // Éxito
                        function(position) {
                            const userLat = position.coords.latitude;
                            const userLng = position.coords.longitude;

                            // Crear control de ruta
                            routingControl = L.Routing.control({
                                waypoints: [
                                    L.latLng(userLat, userLng),
                                    L.latLng({{ $cliente->latitud }}, {{ $cliente->longitud }})
                                ],
                                routeWhileDragging: true,
                                showAlternatives: true,
                                fitSelectedRoutes: true,
                                language: 'es',
                                lineOptions: {
                                    styles: [{ color: '#3388ff', weight: 6 }]
                                },
                                createMarker: function(i, waypoint, n) {
                                    if (i === 0) {
                                        return L.marker(waypoint.latLng, {
                                            icon: L.divIcon({
                                                className: 'my-custom-pin',
                                                html: '<div style="background-color: #3388ff; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white;"></div>',
                                                iconSize: [16, 16],
                                                iconAnchor: [8, 8]
                                            })
                                        }).bindPopup('Tu ubicación actual');
                                    } else {
                                        return clienteMarker;
                                    }
                                }
                            }).addTo(map);

                            document.getElementById('btnRuta').textContent = 'Eliminar Ruta';
                        },
                        // Error
                        function(error) {
                            alert('No se pudo obtener tu ubicación: ' + error.message);
                            document.getElementById('btnRuta').textContent = 'Obtener Ruta hasta aquí';
                        },
                        // Opciones
                        {
                            enableHighAccuracy: true,
                            timeout: 5000,
                            maximumAge: 0
                        }
                    );
                } else {
                    alert('Tu navegador no soporta geolocalización');
                }
            });
        });
    </script>
</x-app-layout>
