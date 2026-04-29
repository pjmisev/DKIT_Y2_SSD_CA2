<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Welcome Back</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sign in to your account</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="input-label text-gray-700 dark:text-gray-300">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="input-field @error('email') input-error @enderror"
                placeholder="you@example.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="input-label text-gray-700 dark:text-gray-300">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="input-field @error('password') input-error @enderror"
                placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember & Forgot -->
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-hoop-500 focus:ring-hoop-500/30 focus:ring-4">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-hoop-600 dark:text-hoop-400 hover:text-hoop-700 dark:hover:text-hoop-300 font-medium transition-colors">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-primary w-full justify-center">
            Sign In
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </button>
    </form>

    <!-- Social Login -->
    @if (config('services.google.client_id') || config('services.github.client_id'))
        <div class="divider text-gray-500 dark:text-gray-400 mt-6 mb-5">or continue with</div>

        <div>
            @if (config('services.google.client_id'))
                <a href="{{ route('auth.provider.redirect', 'google') }}"
                    class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700/50 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-all duration-200">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                    Google
                </a>
            @endif
        </div>
    @endif

    <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-hoop-600 dark:text-hoop-400 hover:text-hoop-700 dark:hover:text-hoop-300 font-semibold transition-colors">Sign up</a>
    </p>
</x-guest-layout>
