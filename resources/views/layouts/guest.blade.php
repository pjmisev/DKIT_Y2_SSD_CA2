<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    </head>
    <body class="font-sans antialiased bg-gray-950 text-white">
        <div class="min-h-screen relative flex flex-col items-center justify-center px-4 py-12">
            <!-- Animated Background -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-hoop-500/20 rounded-full blur-3xl animate-pulse-soft"></div>
                <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-hoop-600/10 rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 1s;"></div>
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 60px 60px;"></div>
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
                    <span class="text-xl font-bold text-white">Hoops Manager</span>
                    <span class="text-xs text-gray-500">Basketball Club Management</span>
                </a>
            </div>

            <!-- Card -->
            <div class="relative w-full max-w-md animate-fade-in-up">
                <div class="glass-card-dark p-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <p class="relative mt-8 text-xs text-gray-600">&copy; {{ date('Y') }} Hoops Manager. All rights reserved.</p>
        </div>
    </body>
</html>
