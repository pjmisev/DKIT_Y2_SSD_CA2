<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Players</h2>
            @if (Auth::user()->isAdmin())
                <a href="{{ route('players.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Player
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Player {{ session('status') === 'player-created' ? 'added' : (session('status') === 'player-updated' ? 'updated' : 'removed') }} successfully.
                </div>
            @endif

            @if ($players->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">No players yet.</p>
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('players.create') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-700 text-sm font-semibold">Add the first player &rarr;</a>
                    @endif
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Position</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Team</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Health</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($players as $player)
                                @php
                                        $healthColors = [
                                            'fit'        => 'bg-green-100 text-green-700',
                                            'injured'    => 'bg-red-100 text-red-700',
                                            'recovering' => 'bg-yellow-100 text-yellow-700',
                                            'suspended'  => 'bg-gray-100 text-gray-600',
                                        ];
                                    @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-400 font-medium">{{ $player->jersey_number !== null ? '#'.$player->jersey_number : '—' }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('players.show', $player) }}" class="font-semibold text-gray-900 hover:text-indigo-600 transition-colors">{{ $player->name }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $player->position ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $player->team ?? '—' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $healthColors[$player->health_status] ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ ucfirst($player->health_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('players.show', $player) }}" class="text-sm text-gray-400 hover:text-indigo-600 transition-colors mr-4">View</a>
                                        @if (Auth::user()->isAdmin())
                                            <a href="{{ route('players.edit', $player) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors mr-4">Edit</a>
                                            <form method="POST" action="{{ route('players.destroy', $player) }}" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Remove {{ addslashes($player->name) }}?')" class="text-sm text-red-500 hover:text-red-700 font-medium transition-colors">Delete</button>
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
