<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('management.index') }}" class="page-header-back">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Management Profile</h2>
                    <p class="text-sm text-gray-500">Detailed management information</p>
                </div>
            </div>
            @auth
                @if (Auth::user()->isAdmin())
                    <div class="flex items-center gap-3">
                        <a href="{{ route('management.edit', $profile) }}" class="btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('management.destroy', $profile) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this member?')" class="btn-danger">
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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="alert-success animate-fade-in-down">
                    <svg class="w-4 h-4 shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Member updated successfully.
                </div>
            @endif

            <!-- Header Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-soft overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-80 h-72 bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 25% 25%, white 0%, transparent 50%), radial-gradient(circle at 75% 75%, white 0%, transparent 50%);"></div>
                        @if ($profile->image)
                            <img src="{{ Storage::url($profile->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-28 h-28 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-4xl shadow-lg border-2 border-white/30">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 p-8">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-gray-500 mt-1">{{ $info->role ?? 'No role set' }}</p>
                            </div>
                            <span class="badge {{ $user->status ? 'badge-green' : 'badge-gray' }}">
                                {{ $user->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div>
                                <span class="text-gray-400 text-xs">Email</span>
                                <p class="font-medium text-gray-800 mt-0.5">{{ $user->email }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs">Team</span>
                                <p class="font-medium text-gray-800 mt-0.5">{{ $profile->team ?? '—' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs">Nationality</span>
                                <p class="font-medium text-gray-800 mt-0.5">{{ $profile->nationality ?? '—' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs">Salary</span>
                                <p class="font-medium text-gray-800 mt-0.5">{{ $user->salary ? '€'.number_format($user->salary) : '—' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs">Date of Birth</span>
                                <p class="font-medium text-gray-800 mt-0.5">{{ $profile->date_of_birth?->format('M d, Y') ?? '—' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs">Department</span>
                                <p class="font-medium text-gray-800 mt-0.5">{{ $info->department ?? '—' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if ($profile->notes)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-soft p-8">
                    <h3 class="section-header">Notes</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $profile->notes }}</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
