<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basketball Club Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen">
        <header style="background-color: #ea580c;" class="text-white shadow-md">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold leading-tight">Hoops Club</h1>
                    <p class="text-xs text-orange-100">Basketball Manager</p>
                </div>

                <nav class="flex items-center gap-6 text-sm font-medium">
                    @auth
                        <a href="{{ route('dashboard') }}" class="hover:text-orange-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-orange-200">Login</a>
                        <a href="{{ route('register') }}" class="hover:text-orange-200">Register</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="max-w-6xl mx-auto px-6 py-10">
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-200">
                <div class="p-8">
                    <div class="rounded-2xl border border-orange-200 bg-orange-50 p-6">
                        <p class="text-sm font-semibold uppercase tracking-wide text-orange-700">Welcome</p>
                        <h2 class="mt-2 text-3xl font-bold text-gray-900">Welcome to Hoops Manager</h2>
                        <p class="mt-3 text-gray-600 max-w-2xl">
                            Manage your basketball club in one place. Please log in below to access players,
                            coaches, events, and management tools.
                        </p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('login') }}" class="inline-flex items-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700 transition-colors">
                                Log In
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                                Create Account
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5">
                            <h3 class="font-semibold text-gray-900">Player Management</h3>
                            <p class="mt-2 text-sm text-gray-600">Keep rosters, positions, and availability organized.</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5">
                            <h3 class="font-semibold text-gray-900">Coach & Staff Tracking</h3>
                            <p class="mt-2 text-sm text-gray-600">Maintain details for coaches and management members.</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5">
                            <h3 class="font-semibold text-gray-900">Event Scheduling</h3>
                            <p class="mt-2 text-sm text-gray-600">Plan training, matches, and club events with ease.</p>
                        </div>
                    </div>

                    <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6">
                        <h3 class="text-xl font-bold text-gray-900">Why Hoops Manager?</h3>
                        <p class="mt-2 text-gray-600">
                            Designed for clubs that want a clean, simple system without changing how their team already works.
                        </p>
                        <ul class="mt-4 space-y-2 text-sm text-gray-700 list-disc list-inside">
                            <li>Fast access to key club information</li>
                            <li>Simple tools for daily updates</li>
                            <li>Secure account-based access for staff</li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>