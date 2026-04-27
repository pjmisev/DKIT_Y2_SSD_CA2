<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('players.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Player Profile</h2>
            </div>
            @auth
                @if (Auth::user()->isAdmin())
                    <div class="flex items-center gap-3">
                        <a href="{{ route('players.edit', $profile) }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('players.destroy', $profile) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this player?')" class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </x-slot>

    @php $user = $profile->user; $info = $profile->profileable; @endphp

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Player updated successfully.
                </div>
            @endif

            <!-- Header Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
                <div class="md:flex">
                    <div class="md:w-72 h-64 bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center relative">
                        @if ($profile->image)
                            <img src="{{ Storage::url($profile->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-24 h-24 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-600 font-bold text-3xl">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        @if ($info->jersey_number)
                            <span class="absolute bottom-4 left-4 bg-white/90 text-gray-800 font-bold text-lg px-3 py-1 rounded-lg shadow-sm">#{{ $info->jersey_number }}</span>
                        @endif
                    </div>
                    <div class="flex-1 p-8">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-gray-500 mt-1">{{ $info->position ?? 'No position set' }}</p>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1.5 rounded-full
                                {{ $info->health_status === 'fit' ? 'bg-green-100 text-green-700' : ($info->health_status === 'injured' ? 'bg-red-100 text-red-700' : ($info->health_status === 'recovering' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600')) }}">
                                {{ ucfirst($info->health_status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-400">Email</span>
                                <p class="font-medium text-gray-800">{{ $user->email }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Team</span>
                                <p class="font-medium text-gray-800">{{ $profile->team ?? '—' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Nationality</span>
                                <p class="font-medium text-gray-800">{{ $profile->nationality ?? '—' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Salary</span>
                                <p class="font-medium text-gray-800">{{ $user->salary ? '€'.number_format($user->salary) : '—' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Date of Birth</span>
                                <p class="font-medium text-gray-800">{{ $profile->date_of_birth?->format('M d, Y') ?? '—' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400">Status</span>
                                <p class="font-medium">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $user->status ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Physical Stats</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-gray-800">{{ $info->height_cm ?? '—' }}</div>
                        <div class="text-xs text-gray-500 mt-1">Height (cm)</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-gray-800">{{ $info->weight_kg ?? '—' }}</div>
                        <div class="text-xs text-gray-500 mt-1">Weight (kg)</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-gray-800">{{ ucfirst($info->dominant_hand ?? '—') }}</div>
                        <div class="text-xs text-gray-500 mt-1">Dominant Hand</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-gray-800">{{ $info->position ?? '—' }}</div>
                        <div class="text-xs text-gray-500 mt-1">Position</div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if ($profile->notes)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Notes</h3>
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $profile->notes }}</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
