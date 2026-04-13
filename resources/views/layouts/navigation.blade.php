<nav x-data="{ open: false }" class="bg-orange-600 border-b border-orange-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center gap-2.5 font-bold text-white text-sm">
                    <div class="w-8 h-8 bg-orange-800 rounded-lg flex items-center justify-center">
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
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-orange-700 text-white' : 'text-orange-300 hover:text-white hover:bg-orange-700' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('players.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('players.*') ? 'bg-orange-700 text-white' : 'text-orange-300 hover:text-white hover:bg-orange-700' }}">
                        Players
                    </a>
                    <a href="{{ route('coaches.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('coaches.*') ? 'bg-orange-700 text-white' : 'text-orange-300 hover:text-white hover:bg-orange-700' }}">
                        Coaches
                    </a>
                    <a href="{{ route('management.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('management.*') ? 'bg-orange-700 text-white' : 'text-orange-300 hover:text-white hover:bg-orange-700' }}">
                        Management
                    </a>
                    <a href="{{ route('events.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('events.*') ? 'bg-orange-700 text-white' : 'text-orange-300 hover:text-white hover:bg-orange-700' }}">
                        Events
                    </a>
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.*') ? 'bg-orange-700 text-white' : 'text-orange-300 hover:text-white hover:bg-orange-700' }}">
                            Admin
                        </a>
                    @endif
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-orange-100 hover:text-white hover:bg-orange-700 transition-colors focus:outline-none">
                            <div class="w-7 h-7 rounded-full bg-orange-800 flex items-center justify-center text-orange-100 text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-orange-300" fill="currentColor" viewBox="0 0 20 20">
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
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-orange-200 hover:text-white hover:bg-orange-700 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-orange-700 bg-orange-600">
        <div class="pt-2 pb-3 px-4 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-orange-700 text-white' : 'text-orange-100 hover:bg-orange-700 hover:text-white' }}">
                Dashboard
            </a>
            @if (request()->routeIs('dashboard'))
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'bg-orange-700 text-white' : 'text-orange-100 hover:bg-orange-700 hover:text-white' }}">
                    Home
                </a>
            @endif
            <a href="{{ route('players.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('players.*') ? 'bg-orange-700 text-white' : 'text-orange-100 hover:bg-orange-700 hover:text-white' }}">
                Players
            </a>
            <a href="{{ route('coaches.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('coaches.*') ? 'bg-orange-700 text-white' : 'text-orange-100 hover:bg-orange-700 hover:text-white' }}">
                Coaches
            </a>
            <a href="{{ route('management.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('management.*') ? 'bg-orange-700 text-white' : 'text-orange-100 hover:bg-orange-700 hover:text-white' }}">
                Management
            </a>
            <a href="{{ route('events.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('events.*') ? 'bg-orange-700 text-white' : 'text-orange-100 hover:bg-orange-700 hover:text-white' }}">
                Events
            </a>
            @if (Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.*') ? 'bg-orange-800 text-white' : 'text-orange-200 hover:bg-orange-800 hover:text-white' }}">
                    Admin
                </a>
            @endif
        </div>

        <div class="border-t border-orange-700 pt-4 pb-3 px-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-orange-800 flex items-center justify-center text-orange-100 text-sm font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-orange-300">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm text-orange-100 hover:bg-orange-700 hover:text-white transition-colors">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm text-orange-100 hover:bg-orange-700 hover:text-white transition-colors">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>
