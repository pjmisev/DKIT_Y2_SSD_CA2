<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Management</h2>
            </div>
            @auth
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('management.create') }}" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Member
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
                    Management member {{ str_replace('management-', '', session('status')) }} successfully.
                </div>
            @endif

            <form method="GET" class="mb-6 flex flex-wrap gap-3">
                <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}"
                    class="rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500 w-64">
                <input type="text" name="team" placeholder="Team..." value="{{ request('team') }}"
                    class="rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500 w-40">
                <input type="text" name="nationality" placeholder="Nationality..." value="{{ request('nationality') }}"
                    class="rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500 w-40">
                <button type="submit" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filter
                </button>
                @if (request()->anyFilled(['search', 'team', 'nationality']))
                    <a href="{{ route('management.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 font-medium">Clear</a>
                @endif
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($profiles as $profile)
                    @php $user = $profile->user; $info = $profile->profileable; @endphp
                    <a href="{{ route('management.show', $profile) }}" class="group block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md hover:border-sky-200 transition-all duration-200">
                        <div class="aspect-[3/2] bg-gradient-to-br from-sky-50 to-sky-100 flex items-center justify-center relative">
                            @if ($profile->image)
                                <img src="{{ Storage::url($profile->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-sky-200 flex items-center justify-center text-sky-600 font-bold text-xl">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 group-hover:text-sky-600 transition-colors truncate">{{ $user->name }}</h3>
                            <div class="flex items-center gap-2 mt-1">
                                @if ($info->role)
                                    <span class="text-xs text-gray-500">{{ $info->role }}</span>
                                @endif
                                @if ($profile->team)
                                    <span class="text-xs text-gray-400">&middot; {{ $profile->team }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6a4 4 0 11-8 0 4 4 0 018 0zM12 11v1m0 4h.01"/></svg>
                        <p class="text-gray-400 text-sm">No management members found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
