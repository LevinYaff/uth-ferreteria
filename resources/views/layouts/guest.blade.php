<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          theme: localStorage.getItem('theme') || 'light',
          isDark: false,

          init() {
              this.isDark = this.theme === 'dark' ||
                         (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

              if (this.isDark) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }

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
      }"
      x-init="init()"
      :class="{'dark': isDark}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FerreSys') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Inicialización temprana del tema para evitar parpadeos -->
        <script>
            if (localStorage.getItem('theme') === 'dark' ||
                (localStorage.getItem('theme') === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-blue-100 to-white dark:from-gray-800 dark:to-gray-900">
            {{ $slot }}
        </div>

        <!-- Theme selector for login page -->
        <div class="fixed bottom-4 right-4 flex space-x-2 bg-white dark:bg-gray-800 p-2 rounded-full shadow-lg">
            <!-- Light Mode -->
            <button type="button" @click="theme = 'light'; localStorage.setItem('theme', 'light'); document.documentElement.classList.remove('dark'); isDark = false;"
                    class="p-2 rounded-full" :class="theme === 'light' ? 'bg-gray-200 dark:bg-gray-700' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>

            <!-- Dark Mode -->
            <button type="button" @click="theme = 'dark'; localStorage.setItem('theme', 'dark'); document.documentElement.classList.add('dark'); isDark = true;"
                    class="p-2 rounded-full" :class="theme === 'dark' ? 'bg-gray-200 dark:bg-gray-700' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>
        </div>
    </body>
</html>
