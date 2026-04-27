<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Players</h2>
            </div>
            @auth
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('players.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
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
                <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Player {{ session('status') === 'player-created' ? 'created' : (session('status') === 'player-updated' ? 'updated' : 'deleted') }} successfully.
                </div>
            @endif

            <!-- Filters -->
            <form method="GET" class="mb-6 flex flex-wrap gap-3">
                <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}"
                    class="rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 w-64">
                <select name="position" class="rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Positions</option>
                    @foreach ($positions as $pos)
                        <option value="{{ $pos }}" {{ request('position') === $pos ? 'selected' : '' }}>{{ $pos }}</option>
                    @endforeach
                </select>
                <select name="health_status" class="rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Health Statuses</option>
                    @foreach ($healthStatuses as $hs)
                        <option value="{{ $hs }}" {{ request('health_status') === $hs ? 'selected' : '' }}>{{ ucfirst($hs) }}</option>
                    @endforeach
                </select>
                <input type="text" name="team" placeholder="Team..." value="{{ request('team') }}"
                    class="rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 w-40">
                <button type="submit" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filter
                </button>
                @if (request()->anyFilled(['search', 'position', 'health_status', 'team']))
                    <a href="{{ route('players.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 font-medium">Clear</a>
                @endif
            </form>

            <!-- Players Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($profiles as $profile)
                    @php $user = $profile->user; $info = $profile->profileable; @endphp
                    <a href="{{ route('players.show', $profile) }}" class="group block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md hover:border-indigo-200 transition-all duration-200">
                        <div class="aspect-[3/2] bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center relative">
                            @if ($profile->image)
                                <img src="{{ Storage::url($profile->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-600 font-bold text-xl">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="absolute top-3 right-3 text-xs font-semibold px-2 py-1 rounded-full
                                {{ $info->health_status === 'fit' ? 'bg-green-100 text-green-700' : ($info->health_status === 'injured' ? 'bg-red-100 text-red-700' : ($info->health_status === 'recovering' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600')) }}">
                                {{ ucfirst($info->health_status) }}
                            </span>
                            @if ($info->jersey_number)
                                <span class="absolute bottom-3 left-3 text-xs font-bold bg-white/80 text-gray-700 px-2 py-1 rounded-lg">#{{ $info->jersey_number }}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors truncate">{{ $user->name }}</h3>
                            <div class="flex items-center gap-2 mt-1">
                                @if ($info->position)
                                    <span class="text-xs text-gray-500">{{ $info->position }}</span>
                                @endif
                                @if ($profile->team)
                                    <span class="text-xs text-gray-400">&middot; {{ $profile->team }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="text-gray-400 text-sm">No players found.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
