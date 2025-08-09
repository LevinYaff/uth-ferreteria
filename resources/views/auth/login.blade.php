<x-guest-layout>
    <div class="min-h-screen flex bg-blue-100 dark:bg-gray-900 relative overflow-hidden">
        <!-- Franja superior con herramientas -->
        <div class="absolute top-0 left-0 right-0 h-24 bg-gray-900 bg-opacity-80 z-0">
            <!-- Imagen de herramientas en la parte superior -->
            <div class="h-full w-full overflow-hidden">
                <img src="{{ asset('images/ferreteria-bg.png') }}" alt="Herramientas" class="w-full h-full object-cover opacity-40">
            </div>
        </div>

        <!-- Imagen lateral izquierda -->
        <div class="hidden md:block fixed left-5 top-3 bottom-0 w-1/4 z-0 overflow-hidden">
            <img src="{{ asset('images/hardware-left.png') }}" alt="Ferretería" class="w-full h-full object-cover opacity-30 hover:opacity-40 transition-opacity duration-500">
        </div>

        <!-- Imagen lateral derecha -->
        <div class="hidden md:block fixed right-7 top-3 bottom-0 w-1/4 z-0 overflow-hidden">
            <img src="{{ asset('images/hardware-right.png') }}" alt="Ferretería" class="w-full h-full object-cover opacity-30 hover:opacity-40 transition-opacity duration-500">
        </div>

        <!-- Contenedor principal -->
        <div class="z-10 w-full max-w-md mx-auto my-12 px-6 py-8 bg-gray-50 dark:bg-gray-800 shadow-lg overflow-hidden rounded-md border border-gray-200 dark:border-gray-700">
            <div class="flex flex-col items-center mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="FerreSys Logo" class="w-32 h-auto mb-6">
                <h1 class="text-3xl font-bold text-ferre dark:text-ferre mb-2">FerreSys®</h1>
                <p class="text-base text-acero dark:text-cemento">Sistema de Administración de Ferretería</p>
                <div class="mt-4 w-16 h-1 bg-ferre rounded-full"></div>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-300 font-medium" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <x-text-input id="email" class="block mt-1 w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@ferreteria.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300 font-medium" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <x-text-input id="password" class="block mt-1 w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-ferre shadow-sm focus:ring-ferre" name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recordarme') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-ferre hover:text-ferre/80" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-2 bg-ferre border border-transparent rounded-md font-semibold text-white text-base uppercase tracking-widest hover:bg-ferre/90 active:bg-ferre/80 focus:outline-none focus:border-ferre focus:ring ring-ferre/30 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        INICIAR SESIÓN
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-8 pt-4 text-center">
                <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                    © 2025 FerreSys®. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>

    <!-- Script para agregar efectos de paralaje sutil -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('mousemove', function(e) {
                const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
                const moveY = (e.clientY - window.innerHeight / 2) * 0.01;

                document.querySelectorAll('.parallax-image').forEach(function(img) {
                    img.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });
            });
        });
    </script>
</x-guest-layout>
