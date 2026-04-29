<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="page-header-back">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Coaches</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage your coaching staff</p>
                </div>
            </div>
            @auth
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('coaches.create') }}" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Coach
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
                    Coach {{ session('status') === 'coach-created' ? 'created' : (session('status') === 'coach-updated' ? 'updated' : 'deleted') }} successfully.
                </div>
            @endif

            <!-- Filters -->
            <form method="GET" class="glass-card p-4 mb-6">
                <div class="flex flex-wrap gap-3 items-end">
                    <div class="flex-1 min-w-48">
                        <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}" class="input-field">
                    </div>
                    <div>
                        <select name="specialization" class="input-field">
                            <option value="">All Specializations</option>
                            @foreach ($roles as $spec)
                                <option value="{{ $spec }}" {{ request('specialization') === $spec ? 'selected' : '' }}>{{ $spec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Filter
                    </button>
                    @if (request()->anyFilled(['search', 'specialization']))
                        <a href="{{ route('coaches.index') }}" class="btn-ghost">Clear</a>
                    @endif
                </div>
            </form>

            <!-- Coaches Grid -->
            <div class="card-grid">
                @forelse ($profiles as $profile)
                    @php $user = $profile->user; $info = $profile->profileable; @endphp
                    <a href="{{ route('coaches.show', $profile) }}" class="group bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-soft overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <div class="aspect-[3/2] bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-800/20 flex items-center justify-center relative overflow-hidden">
                            @if ($profile->image)
                                <img src="{{ Storage::url($profile->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-16 h-16 rounded-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold text-xl shadow-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            @if ($info->specialization)
                                <span class="absolute top-3 right-3 badge badge-emerald">{{ $info->specialization }}</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors truncate">{{ $user->name }}</h3>
                            <div class="flex items-center gap-2 mt-1.5">
                                @if ($info->years_experience)
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $info->years_experience }} years experience</span>
                                @endif
                                @if ($profile->team)
                                    <span class="text-xs text-gray-400 dark:text-gray-500">&middot; {{ $profile->team }}</span>
                                @endif
                            </div>
                            @if ($info->certifications)
                                <div class="mt-3 pt-3 border-t border-gray-50 dark:border-gray-800">
                                    <p class="text-xs text-gray-400 dark:text-gray-500 line-clamp-1">{{ $info->certifications }}</p>
                                </div>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="col-span-full empty-state">
                        <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <p class="empty-state-text">No coaches found.</p>
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('coaches.create') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300">Add your first coach &rarr;</a>
                        @endif
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
