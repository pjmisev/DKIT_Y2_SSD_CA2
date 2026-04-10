<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Coaches</h2>
            @if (Auth::user()->isAdmin())
                <a href="{{ route('coaches.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Coach
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Coach {{ session('status') === 'coach-created' ? 'added' : (session('status') === 'coach-updated' ? 'updated' : 'removed') }} successfully.
                </div>
            @endif

            {{-- Search & filters --}}
            <form method="GET" action="{{ route('coaches.index') }}" class="mb-6 bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
                <div class="flex flex-wrap gap-3">
                    <div class="flex-1 min-w-48">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email…"
                            class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <input type="text" name="team" value="{{ request('team') }}" placeholder="Team…"
                            class="block rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <input type="text" name="nationality" value="{{ request('nationality') }}" placeholder="Nationality…"
                            class="block rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <button type="submit" class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Search
                    </button>
                    @if (request()->hasAny(['search', 'team', 'nationality']))
                        <a href="{{ route('coaches.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 font-medium px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            Clear
                        </a>
                    @endif
                </div>
            </form>

            @if ($coaches->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    @if (request()->hasAny(['search', 'team', 'nationality']))
                        <p class="text-gray-500 font-medium">No coaches match your search.</p>
                        <a href="{{ route('coaches.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-700 text-sm font-semibold">Clear filters &rarr;</a>
                    @else
                        <p class="text-gray-500 font-medium">No coaches yet.</p>
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('coaches.create') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-700 text-sm font-semibold">Add the first coach &rarr;</a>
                        @endif
                    @endif
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Team</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nationality</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($coaches as $coach)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('coaches.show', $coach) }}" class="font-semibold text-gray-900 hover:text-indigo-600 transition-colors">{{ $coach->name }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $coach->team ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $coach->nationality ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $coach->email ?? '—' }}</td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('coaches.show', $coach) }}" class="text-sm text-gray-400 hover:text-indigo-600 transition-colors mr-4">View</a>
                                        @if (Auth::user()->isAdmin())
                                            <a href="{{ route('coaches.edit', $coach) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors mr-4">Edit</a>
                                            <form method="POST" action="{{ route('coaches.destroy', $coach) }}" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Remove {{ addslashes($coach->name) }}?')" class="text-sm text-red-500 hover:text-red-700 font-medium transition-colors">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
