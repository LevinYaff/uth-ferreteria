<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta y Vite -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <!-- Fonts y Scripts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Early Theme Setup (sin errores) -->
    <script>
        const savedTheme = localStorage.getItem('theme') ||
            '{{ Auth::check() ? Auth::user()->theme_preference : (isset($_COOKIE['theme_preference']) ? $_COOKIE['theme_preference'] : 'system') }}';

        if (savedTheme === 'dark' || (savedTheme === 'system' && window.matchMedia('(prefers-color-scheme: dark)')
            .matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans antialiased">
    <!-- ESTE DIV ES IMPORTANTE PARA x-data -->
    <div x-data="{
        theme: localStorage.getItem('theme') || '{{ Auth::check() ? Auth::user()->theme_preference : (isset($_COOKIE['theme_preference']) ? $_COOKIE['theme_preference'] : 'system') }}',
        isDark: false,
        init() {
            this.isDark = this.theme === 'dark' ||
                (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

            this.$watch('theme', (value) => {
                localStorage.setItem('theme', value);
                if (value === 'dark') {
                    document.documentElement.classList.add('dark');
                    this.isDark = true;
                } else if (value === 'light') {
                    document.documentElement.classList.remove('dark');
                    this.isDark = false;
                } else {
                    this.isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    if (this.isDark) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            });

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (this.theme === 'system') {
                    this.isDark = e.matches;
                    if (e.matches) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            });
        }
    }" :class="{ 'bg-gray-100 dark:bg-gray-900': true }">

        <!-- NAV y HEADER -->
        <div class="min-h-screen">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- PAGE CONTENT -->
            <main>
                @if (session('theme_updated'))
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4"
                         x-data="{ show: true }"
                         x-show="show"
                         x-init="setTimeout(() => show = false, 3000)"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2">
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-800 dark:text-green-200"
                            role="alert">
                            <p>{{ session('theme_updated') }}</p>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
