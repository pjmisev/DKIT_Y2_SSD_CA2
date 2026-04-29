<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="page-header-back">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Management</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage your management team</p>
                </div>
            </div>
            @auth
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('management.create') }}" class="btn-primary">
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
                <div class="alert-success mb-6 animate-fade-in-down">
                    <svg class="w-4 h-4 shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Member {{ session('status') === 'management-created' ? 'created' : (session('status') === 'management-updated' ? 'updated' : 'deleted') }} successfully.
                </div>
            @endif

            <!-- Filters -->
            <form method="GET" class="glass-card p-4 mb-6">
                <div class="flex flex-wrap gap-3 items-end">
                    <div class="flex-1 min-w-48">
                        <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}" class="input-field">
                    </div>
                    <div>
                        <select name="role" class="input-field">
                            <option value="">All Roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Filter
                    </button>
                    @if (request()->anyFilled(['search', 'role']))
                        <a href="{{ route('management.index') }}" class="btn-ghost">Clear</a>
                    @endif
                </div>
            </form>

            <!-- Management Grid -->
            <div class="card-grid">
                @forelse ($profiles as $profile)
                    @php $user = $profile->user; $info = $profile->profileable; @endphp
                    <a href="{{ route('management.show', $profile) }}" class="group bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-soft overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <div class="aspect-[3/2] bg-gradient-to-br from-sky-50 to-sky-100 dark:from-sky-900/30 dark:to-sky-800/20 flex items-center justify-center relative overflow-hidden">
                            @if ($profile->image)
                                <img src="{{ Storage::url($profile->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-16 h-16 rounded-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm flex items-center justify-center text-sky-600 dark:text-sky-400 font-bold text-xl shadow-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            @if ($info->role)
                                <span class="absolute top-3 right-3 badge badge-sky">{{ $info->role }}</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors truncate">{{ $user->name }}</h3>
                            <div class="flex items-center gap-2 mt-1.5">
                                @if ($info->department)
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $info->department }}</span>
                                @endif
                                @if ($profile->team)
                                    <span class="text-xs text-gray-400 dark:text-gray-500">&middot; {{ $profile->team }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full empty-state">
                        <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6a4 4 0 11-8 0 4 4 0 018 0zM12 11v1m0 4h.01"/></svg>
                        <p class="empty-state-text">No management members found.</p>
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('management.create') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300">Add your first member &rarr;</a>
                        @endif
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
