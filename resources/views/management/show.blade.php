<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('management.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Management Profile</h2>
            </div>
            @auth
                @if (Auth::user()->isAdmin())
                    <div class="flex items-center gap-3">
                        <a href="{{ route('management.edit', $profile) }}" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">Edit</a>
                        <form method="POST" action="{{ route('management.destroy', $profile) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this member?')" class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">Delete</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </x-slot>

    @php $user = $profile->user; $info = $profile->profileable; @endphp

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
                <div class="md:flex">
                    <div class="md:w-72 h-64 bg-gradient-to-br from-sky-50 to-sky-100 flex items-center justify-center">
                        @if ($profile->image)
                            <img src="{{ Storage::url($profile->image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-24 h-24 rounded-full bg-sky-200 flex items-center justify-center text-sky-600 font-bold text-3xl">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 p-8">
                        <div class="mb-4">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-500 mt-1">{{ $info->role ?? 'No role set' }}</p>
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
                                <p><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $user->status ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $user->status ? 'Active' : 'Inactive' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($profile->notes)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Notes</h3>
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $profile->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
