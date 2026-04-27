<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
                <p class="text-sm text-gray-500 mt-0.5">Welcome back, <span class="font-semibold text-gray-700">{{ Auth::user()->name }}</span></p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <a href="{{ route('players.index') }}" class="stat-card bg-white border border-gray-100 shadow-soft hover:shadow-lg hover:-translate-y-0.5 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Profile::where('profileable_type', \App\Models\PlayerInfo::class)->count() }}</div>
                            <div class="text-sm text-gray-500">Players</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm font-medium text-indigo-600 group-hover:text-indigo-700 flex items-center gap-1">
                            View roster
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>

                <a href="{{ route('coaches.index') }}" class="stat-card bg-white border border-gray-100 shadow-soft hover:shadow-lg hover:-translate-y-0.5 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Profile::where('profileable_type', \App\Models\CoachInfo::class)->count() }}</div>
                            <div class="text-sm text-gray-500">Coaches</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm font-medium text-emerald-600 group-hover:text-emerald-700 flex items-center gap-1">
                            View staff
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>

                <a href="{{ route('management.index') }}" class="stat-card bg-white border border-gray-100 shadow-soft hover:shadow-lg hover:-translate-y-0.5 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-sky-600 flex items-center justify-center shadow-lg shadow-sky-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6a4 4 0 11-8 0 4 4 0 018 0zM12 11v1m0 4h.01"/></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Profile::where('profileable_type', \App\Models\ManagementInfo::class)->count() }}</div>
                            <div class="text-sm text-gray-500">Management</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm font-medium text-sky-600 group-hover:text-sky-700 flex items-center gap-1">
                            View management
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>

                <a href="{{ route('events.index') }}" class="stat-card bg-white border border-gray-100 shadow-soft hover:shadow-lg hover:-translate-y-0.5 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-hoop-500 to-hoop-600 flex items-center justify-center shadow-lg shadow-hoop-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Event::count() }}</div>
                            <div class="text-sm text-gray-500">Events</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm font-medium text-hoop-600 group-hover:text-hoop-700 flex items-center gap-1">
                            View schedule
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>
            </div>

            <!-- Upcoming Events & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Upcoming Events -->
                <div class="lg:col-span-2">
                    @php $upcoming = \App\Models\Event::where('start_time', '>=', now())->orderBy('start_time')->limit(5)->get(); @endphp
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-soft p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="section-header mb-0">Upcoming Events</h3>
                            <a href="{{ route('events.index') }}" class="text-xs font-semibold text-hoop-600 hover:text-hoop-700 transition-colors">View all</a>
                        </div>
                        @if ($upcoming->isNotEmpty())
                            <div class="space-y-2">
                                @foreach ($upcoming as $event)
                                    <a href="{{ route('events.show', $event) }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-gray-50 transition-all duration-150 group">
                                        <div class="text-center w-12 shrink-0">
                                            <div class="text-xs font-bold text-hoop-500 uppercase">{{ $event->start_time->format('M') }}</div>
                                            <div class="text-xl font-black text-gray-800 leading-none">{{ $event->start_time->format('d') }}</div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-gray-800 group-hover:text-hoop-600 transition-colors truncate">{{ $event->name }}</div>
                                            <div class="text-xs text-gray-400 flex items-center gap-2 mt-0.5">
                                                <span>{{ $event->start_time->format('g:i A') }}</span>
                                                @if ($event->location)
                                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                    <span>{{ $event->location }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-sm text-gray-400">No upcoming events</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-soft p-6">
                    <h3 class="section-header">Quick Actions</h3>
                    <div class="space-y-2">
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('players.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-indigo-50 transition-all duration-150 group">
                                <div class="w-9 h-9 rounded-lg bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">Add Player</span>
                            </a>
                            <a href="{{ route('coaches.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-50 transition-all duration-150 group">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-600 transition-colors">Add Coach</span>
                            </a>
                            <a href="{{ route('management.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-sky-50 transition-all duration-150 group">
                                <div class="w-9 h-9 rounded-lg bg-sky-100 flex items-center justify-center group-hover:bg-sky-200 transition-colors">
                                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-sky-600 transition-colors">Add Management</span>
                            </a>
                            <a href="{{ route('events.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-hoop-50 transition-all duration-150 group">
                                <div class="w-9 h-9 rounded-lg bg-hoop-100 flex items-center justify-center group-hover:bg-hoop-200 transition-colors">
                                    <svg class="w-4 h-4 text-hoop-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-hoop-600 transition-colors">Schedule Event</span>
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-all duration-150 group">
                            <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">Edit Profile</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
