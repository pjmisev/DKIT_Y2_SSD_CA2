<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $coach->name }}
            </h2>

            @if (Auth::user()->isAdmin())
                <div class="flex items-center gap-4">
                    <a href="{{ route('coaches.edit', $coach) }}" class="text-yellow-600 hover:text-yellow-800">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('coaches.destroy', $coach) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="text-red-600 hover:text-red-800"
                                onclick="return confirm('Are you sure you want to delete this coach?')">
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status') === 'coach-updated')
                <div class="rounded-lg bg-green-100 px-4 py-3 text-green-700">
                    Coach updated successfully.
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-indigo-100 text-xl font-bold text-indigo-700">
                        {{ strtoupper(substr($coach->name, 0, 1)) }}
                    </div>

                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $coach->name }}</h3>
                        <p class="mt-1 text-gray-600">
                            @if ($coach->role) {{ $coach->role }} @endif
                            @if ($coach->role && $coach->team) · @endif
                            @if ($coach->team) {{ $coach->team }} @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact</h3>

                    <div class="space-y-3 text-sm text-gray-700">
                        <div>
                            <span class="font-medium text-gray-900">Email:</span>
                            {{ $coach->email ?? '—' }}
                        </div>

                        <div>
                            <span class="font-medium text-gray-900">Phone:</span>
                            {{ $coach->phone ?? '—' }}
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Club Info</h3>

                    <div class="space-y-3 text-sm text-gray-700">
                        <div>
                            <span class="font-medium text-gray-900">Role:</span>
                            {{ $coach->role ?? '—' }}
                        </div>

                        <div>
                            <span class="font-medium text-gray-900">Team:</span>
                            {{ $coach->team ?? '—' }}
                        </div>

                        <div>
                            <span class="font-medium text-gray-900">Experience:</span>
                            {{ $coach->experience_years !== null ? $coach->experience_years . ' years' : '—' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-sm text-gray-500">
                Added by {{ $coach->creator?->name ?? '—' }} · {{ $coach->created_at->format('M d, Y') }}
            </div>
        </div>
    </div>
</x-app-layout>