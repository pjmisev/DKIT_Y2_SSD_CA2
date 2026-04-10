<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('players.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $player->name }}</h2>
            </div>
            @if (Auth::user()->isAdmin())
                <div class="flex items-center gap-3">
                    <a href="{{ route('players.edit', $player) }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">Edit</a>
                    <form method="POST" action="{{ route('players.destroy', $player) }}">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Remove {{ addslashes($player->name) }}?')" class="inline-flex items-center bg-white hover:bg-red-50 text-red-600 border border-red-200 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">Delete</button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Header card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-center gap-5">
                <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 font-black text-2xl shrink-0">
                    {{ $player->jersey_number !== null ? '#'.$player->jersey_number : strtoupper(substr($player->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xl font-bold text-gray-900">{{ $player->name }}</div>
                    <div class="text-sm text-gray-400 mt-0.5 flex items-center gap-2 flex-wrap">
                        @if ($player->position) <span>{{ $player->position }}</span> @endif
                        @if ($player->position && $player->team) <span>&middot;</span> @endif
                        @if ($player->team) <span>{{ $player->team }}</span> @endif
                    </div>
                </div>
                @php
                    $healthColors = [
                        'fit'        => 'bg-green-100 text-green-700',
                        'injured'    => 'bg-red-100 text-red-700',
                        'recovering' => 'bg-yellow-100 text-yellow-700',
                        'suspended'  => 'bg-gray-100 text-gray-600',
                    ];
                @endphp
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $healthColors[$player->health_status] ?? 'bg-gray-100 text-gray-600' }}">
                    {{ ucfirst($player->health_status) }}
                </span>
            </div>

            {{-- Details grid --}}
            <div class="grid grid-cols-2 gap-5">

                {{-- Identity --}}
                <div class="col-span-2 sm:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Identity</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Email</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $player->email ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Date of Birth</dt>
                            <dd class="text-sm font-medium text-gray-800">
                                @if ($player->date_of_birth)
                                    {{ $player->date_of_birth->format('M d, Y') }}
                                    <span class="text-gray-400">({{ $player->date_of_birth->age }} yrs)</span>
                                @else —
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Nationality</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $player->nationality ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Dominant Hand</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $player->dominant_hand ? ucfirst($player->dominant_hand) : '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Jersey #</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $player->jersey_number !== null ? '#'.$player->jersey_number : '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Salary</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $player->salary !== null ? '€'.number_format($player->salary) : '—' }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Physical --}}
                <div class="col-span-2 sm:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Physical</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Height</dt>
                            <dd class="text-sm font-medium text-gray-800">
                                @if ($player->height_cm)
                                    {{ $player->height_cm }} cm
                                    @php
                                        $inches = round($player->height_cm / 2.54);
                                        $ft = intdiv($inches, 12);
                                        $in = $inches % 12;
                                    @endphp
                                    <span class="text-gray-400">({{ $ft }}'{{ $in }}")</span>
                                @else —
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Weight</dt>
                            <dd class="text-sm font-medium text-gray-800">
                                @if ($player->weight_kg)
                                    {{ $player->weight_kg }} kg
                                    <span class="text-gray-400">({{ round($player->weight_kg * 2.205) }} lbs)</span>
                                @else —
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Position</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $player->position ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Team</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $player->team ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Health --}}
                @if ($player->notes)
                    <div class="col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Health Notes</h3>
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $player->notes }}</p>
                    </div>
                @endif

            </div>

            <p class="text-xs text-gray-400 text-right">Added by {{ $player->creator?->name ?? '—' }} &middot; {{ $player->created_at->format('M d, Y') }}</p>
        </div>
    </div>
</x-app-layout>
