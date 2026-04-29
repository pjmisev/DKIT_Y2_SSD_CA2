<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="page-header-back">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Teams</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage basketball teams</p>
                </div>
            </div>
            <a href="{{ route('admin.teams.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Team
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="alert-success mb-6 animate-fade-in-down">
                    <svg class="w-4 h-4 shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    @if (session('status') === 'team-created')
                        Team created successfully.
                    @elseif (session('status') === 'team-updated')
                        Team updated successfully.
                    @elseif (session('status') === 'team-deleted')
                        Team deleted successfully.
                    @elseif (session('status') === 'team-has-members')
                        <span class="text-amber-600">Cannot delete a team that has members. Reassign or remove members first.</span>
                    @endif
                </div>
            @endif

            <div class="card-grid">
                @forelse ($teams as $team)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-soft overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <div class="h-2" style="background-color: {{ $team->theme_color }}"></div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-sm" style="background-color: {{ $team->theme_color }}">
                                        {{ strtoupper(substr($team->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $team->name }}</h3>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ $team->users_count }} member{{ $team->users_count !== 1 ? 's' : '' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="w-5 h-5 rounded-full border-2 border-gray-200 dark:border-gray-600" style="background-color: {{ $team->theme_color }}" title="{{ $team->theme_color }}"></span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-xs text-gray-400 dark:text-gray-500 font-mono">{{ $team->theme_color }}</span>
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.teams.edit', $team) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">Edit</a>
                                    <form method="POST" action="{{ route('admin.teams.destroy', $team) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete {{ addslashes($team->name) }}?')" class="text-sm font-medium text-red-500 hover:text-red-700 transition-colors">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full empty-state">
                        <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="empty-state-text">No teams created yet.</p>
                        <a href="{{ route('admin.teams.create') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300">Create your first team &rarr;</a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
