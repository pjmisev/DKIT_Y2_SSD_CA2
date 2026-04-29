<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="themeManager()" x-init="initTheme()" :class="{ 'dark': isDark }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hoops Manager') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // Prevent flash of wrong theme
            if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="relative min-h-screen bg-gray-50 dark:bg-gray-950 overflow-hidden">
            <!-- Background Image -->
            <div class="fixed inset-0 bg-center bg-cover opacity-[0.06] dark:opacity-[0.03]" style="background-image: url('{{ asset('images/login-bg.jpg') }}');"></div>
            <div class="fixed inset-0 bg-gradient-to-b from-gray-50/90 via-gray-50/95 to-gray-50 dark:from-gray-950/90 dark:via-gray-950/95 dark:to-gray-950"></div>

            <div class="relative z-10">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white/80 backdrop-blur-md border-b border-gray-100/50 shadow-sm dark:bg-gray-900/80 dark:border-gray-800/50">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
