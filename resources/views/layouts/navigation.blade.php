@php
    $team = Auth::user()->team;
    $themeColor = $team?->theme_color ?? '#ea580c'; // default orange-600
    $themeColor700 = $themeColor; // will be darkened via inline style
    $themeColor800 = $themeColor;
    $themeColor300 = $themeColor;
    $themeColor200 = $themeColor;
    $themeColor100 = $themeColor;
@endphp
<nav x-data="{ open: false }" class="border-b" style="background-color: {{ $themeColor }}; border-color: {{ $themeColor }};">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center gap-2.5 font-bold text-white text-sm">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: rgba(0,0,0,0.2);">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="8" fill="none" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M10 2a8 8 0 100 16A8 8 0 0010 2z" fill="currentColor" opacity=".15"/>
                            <path stroke="currentColor" stroke-width="1.5" d="M2.5 10h15M10 2.5v15M4.5 4.5l11 11M15.5 4.5l-11 11" stroke-linecap="round"/>
                        </svg>
                    </div>
                    Hoops Manager
                </a>

                <!-- Nav Links -->
                <div class="hidden sm:flex sm:items-center sm:gap-1 sm:ms-8">
                    <a href="{{ route('dashboard') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                        style="{{ request()->routeIs('dashboard') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.7);' }}"
                        onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                        onmouseout="this.style.backgroundColor='{{ request()->routeIs('dashboard') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('dashboard') ? 'white' : 'rgba(255,255,255,0.7)' }}';">
                        Dashboard
                    </a>
                    <a href="{{ route('players.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                        style="{{ request()->routeIs('players.*') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.7);' }}"
                        onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                        onmouseout="this.style.backgroundColor='{{ request()->routeIs('players.*') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('players.*') ? 'white' : 'rgba(255,255,255,0.7)' }}';">
                        Players
                    </a>
                    <a href="{{ route('coaches.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                        style="{{ request()->routeIs('coaches.*') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.7);' }}"
                        onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                        onmouseout="this.style.backgroundColor='{{ request()->routeIs('coaches.*') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('coaches.*') ? 'white' : 'rgba(255,255,255,0.7)' }}';">
                        Coaches
                    </a>
                    <a href="{{ route('management.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                        style="{{ request()->routeIs('management.*') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.7);' }}"
                        onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                        onmouseout="this.style.backgroundColor='{{ request()->routeIs('management.*') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('management.*') ? 'white' : 'rgba(255,255,255,0.7)' }}';">
                        Management
                    </a>
                    <a href="{{ route('events.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                        style="{{ request()->routeIs('events.*') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.7);' }}"
                        onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                        onmouseout="this.style.backgroundColor='{{ request()->routeIs('events.*') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('events.*') ? 'white' : 'rgba(255,255,255,0.7)' }}';">
                        Events
                    </a>
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                            style="{{ request()->routeIs('admin.*') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.7);' }}"
                            onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='{{ request()->routeIs('admin.*') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('admin.*') ? 'white' : 'rgba(255,255,255,0.7)' }}';">
                            Admin
                        </a>
                    @endif
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-colors focus:outline-none"
                            style="color: rgba(255,255,255,0.9);"
                            onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.9)';">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold"
                                style="background-color: rgba(0,0,0,0.2); color: rgba(255,255,255,0.9);">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" style="color: rgba(255,255,255,0.5);" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out"
                    style="color: rgba(255,255,255,0.7);"
                    onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.7)';">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="border-top: 1px solid rgba(0,0,0,0.1); background-color: {{ $themeColor }};">
        <div class="pt-2 pb-3 px-4 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                style="{{ request()->routeIs('dashboard') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.9);' }}"
                onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='{{ request()->routeIs('dashboard') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('dashboard') ? 'white' : 'rgba(255,255,255,0.9)' }}';">
                Dashboard
            </a>
            @if (request()->routeIs('dashboard'))
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                    style="{{ request()->routeIs('home') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.9);' }}"
                    onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='{{ request()->routeIs('home') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('home') ? 'white' : 'rgba(255,255,255,0.9)' }}';">
                    Home
                </a>
            @endif
            <a href="{{ route('players.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                style="{{ request()->routeIs('players.*') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.9);' }}"
                onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='{{ request()->routeIs('players.*') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('players.*') ? 'white' : 'rgba(255,255,255,0.9)' }}';">
                Players
            </a>
            <a href="{{ route('coaches.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                style="{{ request()->routeIs('coaches.*') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.9);' }}"
                onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='{{ request()->routeIs('coaches.*') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('coaches.*') ? 'white' : 'rgba(255,255,255,0.9)' }}';">
                Coaches
            </a>
            <a href="{{ route('management.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                style="{{ request()->routeIs('management.*') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.9);' }}"
                onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='{{ request()->routeIs('management.*') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('management.*') ? 'white' : 'rgba(255,255,255,0.9)' }}';">
                Management
            </a>
            <a href="{{ route('events.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                style="{{ request()->routeIs('events.*') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.9);' }}"
                onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='{{ request()->routeIs('events.*') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('events.*') ? 'white' : 'rgba(255,255,255,0.9)' }}';">
                Events
            </a>
            @if (Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                    style="{{ request()->routeIs('admin.*') ? 'background-color: rgba(0,0,0,0.2); color: white;' : 'color: rgba(255,255,255,0.9);' }}"
                    onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='{{ request()->routeIs('admin.*') ? 'rgba(0,0,0,0.2)' : 'transparent' }}'; this.style.color='{{ request()->routeIs('admin.*') ? 'white' : 'rgba(255,255,255,0.9)' }}';">
                    Admin
                </a>
            @endif
        </div>

        <div class="border-t px-4 py-3" style="border-color: rgba(0,0,0,0.1);">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold"
                    style="background-color: rgba(0,0,0,0.2); color: rgba(255,255,255,0.9);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                    <div class="text-xs" style="color: rgba(255,255,255,0.6);">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm transition-colors"
                    style="color: rgba(255,255,255,0.9);"
                    onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.9)';">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm transition-colors"
                        style="color: rgba(255,255,255,0.9);"
                        onmouseover="this.style.backgroundColor='rgba(0,0,0,0.2)'; this.style.color='white';"
                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='rgba(255,255,255,0.9)';">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>
