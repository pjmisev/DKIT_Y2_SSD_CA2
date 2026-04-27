<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Basketball Club Manager') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 overflow-hidden">
            @if (request()->routeIs('login'))
                <div class="absolute inset-0 bg-center bg-cover opacity-70" style="background-image: url('{{ asset('images/login-bg.jpg') }}');"></div>
                <div class="absolute inset-0 bg-gray-900/25"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-orange-600/25 via-transparent to-gray-100/35"></div>
            @endif

            <div>
                <a href="/" class="flex flex-col items-center">
                    <span class="text-2xl font-bold leading-tight {{ request()->routeIs('login') ? 'text-white drop-shadow-sm' : 'text-orange-600' }}">Hoops Club</span>
                    <span class="text-xs {{ request()->routeIs('login') ? 'text-orange-100' : 'text-gray-500' }}">Basketball Manager</span>
                </a>
            </div>

            <div class="relative w-full sm:max-w-md mt-6 px-6 py-4 bg-white/95 shadow-md overflow-hidden sm:rounded-lg border border-white/70 backdrop-blur-sm">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
