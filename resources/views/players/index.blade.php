<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="page-header-back">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Players</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage your team roster</p>
                </div>
            </div>
            @auth
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('players.create') }}" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Player
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="alert-success mb-6 animate-fade-in-down">
                    <svg class="w-4 h-4 shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Player {{ session('status') === 'player-created' ? 'created' : (session('status') === 'player-updated' ? 'updated' : 'deleted') }} successfully.
                </div>
            @endif

            <!-- Filters -->
            <form method="GET" class="glass-card p-4 mb-6">
                <div class="flex flex-wrap gap-3 items-end">
                    <div class="flex-1 min-w-48">
                        <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}"
                            class="input-field">
                    </div>
                    <div>
                        <select name="position" class="input-field">
                            <option value="">All Positions</option>
                            @foreach ($positions as $pos)
                                <option value="{{ $pos }}" {{ request('position') === $pos ? 'selected' : '' }}>{{ $pos }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="health_status" class="input-field">
                            <option value="">All Health Statuses</option>
                            @foreach ($healthStatuses as $hs)
                                <option value="{{ $hs }}" {{ request('health_status') === $hs ? 'selected' : '' }}>{{ ucfirst($hs) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input type="text" name="team" placeholder="Team..." value="{{ request('team') }}"
                            class="input-field w-36">
                    </div>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Filter
                    </button>
                    @if (request()->anyFilled(['search', 'position', 'health_status', 'team']))
                        <a href="{{ route('players.index') }}" class="btn-ghost">Clear</a>
                    @endif
                </div>
            </form>

            <!-- Players Grid -->
            <div class="card-grid">
                @forelse ($profiles as $profile)
                    @php $user = $profile->user; $info = $profile->profileable; @endphp
                    <a href="{{ route('players.show', $profile) }}" class="group bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-soft overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <div class="aspect-[3/2] bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/30 dark:to-indigo-800/20 flex items-center justify-center relative overflow-hidden">
                            @if ($profile->image)
                                <img src="{{ Storage::url($profile->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-16 h-16 rounded-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xl shadow-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <!-- Health Status Badge -->
                            <span class="absolute top-3 right-3 badge
                                {{ $info->health_status === 'fit' ? 'badge-green' : ($info->health_status === 'injured' ? 'badge-red' : ($info->health_status === 'recovering' ? 'badge-yellow' : 'badge-gray')) }}">
                                {{ ucfirst($info->health_status) }}
                            </span>
                            @if ($info->jersey_number)
                                <span class="absolute bottom-3 left-3 text-xs font-bold bg-white/90 dark:bg-gray-800/90 text-gray-700 dark:text-gray-300 px-2.5 py-1 rounded-lg shadow-sm backdrop-blur-sm">#{{ $info->jersey_number }}</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors truncate">{{ $user->name }}</h3>
                            <div class="flex items-center gap-2 mt-1.5">
                                @if ($info->position)
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $info->position }}</span>
                                @endif
                                @if ($profile->team)
                                    <span class="text-xs text-gray-400 dark:text-gray-500">&middot; {{ $profile->team }}</span>
                                @endif
                            </div>
                            @if ($info->height_cm || $info->weight_kg)
                                <div class="mt-3 pt-3 border-t border-gray-50 dark:border-gray-800 flex items-center gap-3 text-xs text-gray-400 dark:text-gray-500">
                                    @if ($info->height_cm)<span>{{ $info->height_cm }} cm</span>@endif
                                    @if ($info->weight_kg)<span>{{ $info->weight_kg }} kg</span>@endif
                                </div>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="col-span-full empty-state">
                        <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="empty-state-text">No players found.</p>
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('players.create') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">Add your first player &rarr;</a>
                        @endif
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
