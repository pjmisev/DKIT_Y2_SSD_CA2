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
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-white">
        <div class="min-h-screen relative flex flex-col items-center justify-center px-4 py-12">
            <!-- Animated Background -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute inset-0 bg-center bg-cover opacity-20 dark:opacity-25" style="background-image: url('{{ asset('images/login-bg.jpg') }}');"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-gray-50/90 via-gray-50/95 to-gray-50 dark:from-gray-950/80 dark:via-gray-950/70 dark:to-gray-950"></div>
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-hoop-500/20 rounded-full blur-3xl animate-pulse-soft"></div>
                <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-hoop-600/10 rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 1s;"></div>
                <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.03]" style="background-image: linear-gradient(rgba(0,0,0,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.05) 1px, transparent 1px); background-size: 60px 60px;"></div>
            </div>

            <!-- Theme Toggle -->
            <div class="absolute top-4 right-4 z-20">
                <button @click="toggleTheme()"
                    class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-400 dark:text-white/50 hover:text-gray-600 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-white/10 transition-all duration-200"
                    title="Toggle theme">
                    <template x-if="isDark">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </template>
                    <template x-if="!isDark">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </template>
                </button>
            </div>

            <!-- Logo -->
            <div class="relative mb-8 animate-fade-in-down">
                <a href="/" class="flex flex-col items-center gap-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-hoop-500 to-hoop-700 flex items-center justify-center shadow-lg shadow-hoop-500/25 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 2v20M2 12h20" stroke-linecap="round"/>
                            <path d="M4.93 4.93l14.14 14.14M19.07 4.93L4.93 19.07" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">Hoops Manager</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Basketball Club Management</span>
                </a>
            </div>

            <!-- Card -->
            <div class="relative w-full max-w-md animate-fade-in-up">
                <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border border-gray-200 dark:border-gray-700/50 shadow-soft rounded-2xl p-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <p class="relative mt-8 text-xs text-gray-400 dark:text-gray-600">&copy; {{ date('Y') }} Hoops Manager. All rights reserved.</p>
        </div>
    </body>
</html>
