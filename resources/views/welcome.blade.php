<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="themeManager()" x-init="initTheme()" :class="{ 'dark': isDark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hoops Manager — Basketball Club Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Prevent flash of wrong theme
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-white antialiased">
    <div class="min-h-screen relative overflow-hidden">
        <!-- Background Image with Overlays -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-center bg-cover opacity-20 dark:opacity-20" style="background-image: url('{{ asset('images/login-bg.jpg') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-gray-50/90 via-gray-50/95 to-gray-50 dark:from-gray-950/80 dark:via-gray-950/70 dark:to-gray-950"></div>
            <!-- Gradient orbs -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-hoop-500/20 rounded-full blur-3xl animate-pulse-soft"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-hoop-600/10 rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-hoop-500/5 rounded-full blur-3xl"></div>
            <!-- Grid pattern -->
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

        <!-- Header -->
        <header class="relative z-10">
            <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-hoop-500 to-hoop-700 flex items-center justify-center shadow-lg shadow-hoop-500/25">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 2v20M2 12h20" stroke-linecap="round"/>
                            <path d="M4.93 4.93l14.14 14.14M19.07 4.93L4.93 19.07" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-lg font-bold text-gray-900 dark:text-white">Hoops Manager</span>
                        <span class="hidden sm:inline text-sm text-gray-500 dark:text-gray-400 ml-2">Basketball Club Management</span>
                    </div>
                </div>

                <nav class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors px-4 py-2">Log In</a>
                        <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="relative z-10">
            <section class="max-w-7xl mx-auto px-6 pt-20 pb-16 text-center">
                <div class="animate-fade-in-up">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-sm text-gray-500 dark:text-gray-400 mb-8">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse-soft"></span>
                        Basketball Club Management Platform
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        <span class="text-gray-900 dark:text-white">Manage Your</span><br>
                        <span class="gradient-text">Basketball Club</span>
                    </h1>

                    <p class="mt-6 text-lg sm:text-xl text-gray-500 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
                        The all-in-one platform for managing players, coaches, events, and staff — 
                        designed for clubs that want a clean, simple system.
                    </p>

                    <div class="mt-10 flex flex-wrap justify-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-primary text-base px-8 py-3">
                                Go to Dashboard
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-primary text-base px-8 py-3">
                                Start Free
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.97] text-base px-8 py-3">
                                Sign In
                            </a>
                        @endauth
                    </div>
                </div>
            </section>

            <!-- Features Grid -->
            <section class="max-w-7xl mx-auto px-6 pb-24">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border border-gray-200 dark:border-gray-700/50 shadow-soft rounded-2xl p-8 animate-fade-in-up hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-hoop-500 to-hoop-600 flex items-center justify-center mb-5">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Player Management</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Keep rosters, positions, and availability organized in one place.</p>
                    </div>

                    <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border border-gray-200 dark:border-gray-700/50 shadow-soft rounded-2xl p-8 animate-fade-in-up hover:-translate-y-1 transition-all duration-300" style="animation-delay: 100ms;">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center mb-5">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Coach & Staff Tracking</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Maintain detailed profiles for coaches and management members.</p>
                    </div>

                    <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border border-gray-200 dark:border-gray-700/50 shadow-soft rounded-2xl p-8 animate-fade-in-up hover:-translate-y-1 transition-all duration-300" style="animation-delay: 200ms;">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mb-5">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Event Scheduling</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Plan training sessions, matches, and club events with ease.</p>
                    </div>
                </div>
            </section>

            <!-- Bottom CTA -->
            <section class="max-w-7xl mx-auto px-6 pb-24">
                <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border border-gray-200 dark:border-gray-700/50 shadow-soft rounded-2xl p-12 text-center animate-fade-in-up">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Ready to get started?</h2>
                    <p class="text-gray-500 dark:text-gray-400 max-w-lg mx-auto mb-8">
                        Join clubs already using Hoops Manager to streamline their operations.
                    </p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary text-base px-8 py-3">Go to Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary text-base px-8 py-3">Create Your Account</a>
                    @endauth
                </div>
            </section>

            <!-- Footer -->
            <footer class="max-w-7xl mx-auto px-6 pb-8 text-center">
                <p class="text-sm text-gray-400 dark:text-gray-600">&copy; {{ date('Y') }} Hoops Manager. Built with Laravel.</p>
            </footer>
        </main>
        </div>
    </div>
</body>
</html>
