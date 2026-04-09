<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Coaches
            </h2>

            @if (Auth::user()->isAdmin())
                <a href="{{ route('coaches.create') }}"
                   class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white text-sm font-medium hover:bg-indigo-700">
                    Add Coach
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-green-700">
                    Coach
                    {{ session('status') === 'coach-created' ? 'added' : (session('status') === 'coach-updated' ? 'updated' : 'removed') }}
                    successfully.
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                @if ($coaches->isEmpty())
                    <div class="p-6 text-gray-600">
                        No coaches yet.

                        @if (Auth::user()->isAdmin())
                            <div class="mt-4">
                                <a href="{{ route('coaches.create') }}" class="text-indigo-600 hover:text-indigo-800">
                                    Add the first coach →
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Team</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($coaches as $coach)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ $coach->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $coach->role ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $coach->team ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $coach->email ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <a href="{{ route('coaches.show', $coach) }}" class="text-indigo-600 hover:text-indigo-800">
                                                View
                                            </a>

                                            @if (Auth::user()->isAdmin())
                                                <a href="{{ route('coaches.edit', $coach) }}" class="ml-4 text-yellow-600 hover:text-yellow-800">
                                                    Edit
                                                </a>

                                                <form method="POST" action="{{ route('coaches.destroy', $coach) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="ml-4 text-red-600 hover:text-red-800"
                                                            onclick="return confirm('Are you sure you want to delete this coach?')">
                                                        Delete
                                                    </button>
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
    </div>
</x-app-layout>