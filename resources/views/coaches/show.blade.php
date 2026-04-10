<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('coaches.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $coach->name }}</h2>
            </div>
            @if (Auth::user()->isAdmin())
                <div class="flex items-center gap-3">
                    <a href="{{ route('coaches.edit', $coach) }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">Edit</a>
                    <form method="POST" action="{{ route('coaches.destroy', $coach) }}">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Remove {{ addslashes($coach->name) }}?')" class="inline-flex items-center bg-white hover:bg-red-50 text-red-600 border border-red-200 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">Delete</button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            @if (session('status') === 'coach-updated')
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Coach updated successfully.
                </div>
            @endif

            {{-- Header card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-center gap-5">
                <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 font-black text-2xl shrink-0">
                    {{ strtoupper(substr($coach->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xl font-bold text-gray-900">{{ $coach->name }}</div>
                    <div class="text-sm text-gray-400 mt-0.5">
                        @if ($coach->team) {{ $coach->team }} @endif
                    </div>
                </div>
            </div>

            {{-- Details grid --}}
            <div class="grid grid-cols-2 gap-5">

                {{-- Identity --}}
                <div class="col-span-2 sm:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Identity</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Email</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $coach->email ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Date of Birth</dt>
                            <dd class="text-sm font-medium text-gray-800">
                                @if ($coach->date_of_birth)
                                    {{ $coach->date_of_birth->format('M d, Y') }}
                                    <span class="text-gray-400">({{ $coach->date_of_birth->age }} yrs)</span>
                                @else —
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Nationality</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $coach->nationality ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Club & Contract --}}
                <div class="col-span-2 sm:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Club & Contract</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Team</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $coach->team ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Salary</dt>
                            <dd class="text-sm font-medium text-gray-800">{{ $coach->salary !== null ? '€'.number_format($coach->salary) : '—' }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Notes --}}
                @if ($coach->notes)
                    <div class="col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Notes</h3>
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $coach->notes }}</p>
                    </div>
                @endif

            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Linked Account</h3>
                <p class="text-sm text-gray-800 font-medium">{{ $coach->linkedUser?->name ?? '—' }}</p>
                @if ($coach->linkedUser)
                    <p class="text-xs text-gray-400 mt-0.5">{{ $coach->linkedUser->email }}</p>
                @endif
            </div>

            <p class="text-xs text-gray-400 text-right">Added by {{ $coach->creator?->name ?? '—' }} &middot; {{ $coach->created_at->format('M d, Y') }}</p>
        </div>
    </div>
</x-app-layout>
