<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FerreSys® - Sistema de Administración de Ferretería</title>

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Header/Navigation -->
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/logo.png') }}" alt="FerreSys Logo" class="h-10">
                    </div>
                    <div class="ml-2">
                        <span class="text-xl font-bold text-ferre dark:text-ferre">FerreSys</span>
                        <span class="text-gray-800 dark:text-gray-200 font-semibold">®</span>
                    </div>
                </div>

                <div>
                    @if (Route::has('login'))
                        <div class="flex items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="bg-ferre hover:bg-ferre/90 text-white font-semibold py-2 px-4 rounded-md inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="bg-ferre hover:bg-ferre/90 text-white font-semibold py-2 px-4 rounded-md inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Iniciar Sesión / Registrarse
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="py-12 text-center">
        <h1 class="text-4xl font-bold text-tecnico dark:text-tecnico mb-4">Bienvenido a FerreSys</h1>
        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">Tu solución completa para la gestión de
            ferreterías</p>
    </div>

    <!-- Features Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Inventario -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-start">
                    <div class="bg-herramienta/20 dark:bg-herramienta/10 p-3 rounded-full">
                        <svg class="w-12 h-12 text-herramienta" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h2 class="text-xl font-semibold text-acero dark:text-cemento mb-3">Gestión de Inventario</h2>
                        <p class="text-gray-600 dark:text-gray-400">Administra fácilmente tu inventario, controla
                            existencias y recibe alertas de stock bajo. Mantén un seguimiento detallado de todos tus
                            productos.</p>
                    </div>
                </div>
            </div>

            <!-- Ventas -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-start">
                    <div class="bg-ferre/20 dark:bg-ferre/10 p-3 rounded-full">
                        <svg class="w-12 h-12 text-ferre" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h2 class="text-xl font-semibold text-acero dark:text-cemento mb-3">Gestión de Ventas</h2>
                        <p class="text-gray-600 dark:text-gray-400">Mantén un registro completo de tus ventas,
                            incluyendo datos de clientes, historial de compras y genera facturas automáticamente.</p>
                    </div>
                </div>
            </div>

            <!-- Usuarios -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-start">
                    <div class="bg-tecnico/20 dark:bg-tecnico/10 p-3 rounded-full">
                        <svg class="w-12 h-12 text-tecnico" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h2 class="text-xl font-semibold text-acero dark:text-cemento mb-3">Control de Usuarios</h2>
                        <p class="text-gray-600 dark:text-gray-400">Administra tu personal, asigna roles y permisos, y
                            mantén un control eficiente del equipo de trabajo de tu ferretería.</p>
                    </div>
                </div>
            </div>

            <!-- Compras -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-start">
                    <div class="bg-acero/20 dark:bg-acero/10 p-3 rounded-full">
                        <svg class="w-12 h-12 text-acero" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h2 class="text-xl font-semibold text-acero dark:text-cemento mb-3">Gestión de Compras</h2>
                        <p class="text-gray-600 dark:text-gray-400">Gestiona las compras a proveedores, genera órdenes
                            de compra y mantén un registro detallado de todos los ingresos a tu inventario.</p>
                    </div>
                </div>
            </div>

            <!-- Clientes -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-start">
                    <div class="bg-cemento/30 dark:bg-cemento/10 p-3 rounded-full">
                        <svg class="w-12 h-12 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h2 class="text-xl font-semibold text-acero dark:text-cemento mb-3">Gestión de Clientes</h2>
                        <p class="text-gray-600 dark:text-gray-400">Mantén un registro completo de tus clientes,
                            incluyendo datos personales, historial de compras y preferencias para ofrecer un mejor
                            servicio.</p>
                    </div>
                </div>
            </div>

            <!-- Reportes -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-start">
                    <div class="bg-herramienta/20 dark:bg-herramienta/10 p-3 rounded-full">
                        <svg class="w-12 h-12 text-herramienta" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h2 class="text-xl font-semibold text-acero dark:text-cemento mb-3">Reportes y Estadísticas
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400">Genera reportes detallados sobre ventas,
                            inventario, clientes y finanzas. Visualiza estadísticas que te ayudarán a tomar mejores
                            decisiones.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-ferre/90 to-tecnico/90 py-12 mt-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-6">Comienza a gestionar tu ferretería de manera profesional
            </h2>
            <p class="text-white/90 mb-8 text-lg">FerreSys© te ofrece todas las herramientas que necesitas para
                administrar eficientemente tu negocio.</p>
            <a href="{{ route('login') }}"
                class="bg-white text-ferre font-bold py-3 px-6 rounded-lg shadow-lg hover:bg-gray-100 transition duration-300 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                    </path>
                </svg>
                Comenzar Ahora
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 py-8 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-600 dark:text-gray-400">FerreSys© {{ date('Y') }} - Todos los derechos
                    reservados</p>
            </div>
        </div>
    </footer>
</body>

</html>
