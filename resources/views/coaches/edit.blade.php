<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Coach
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('coaches.update', $coach) }}" class="space-y-8">
                    @csrf
                    @method('PATCH')

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Coach Details</h3>
                        <div class="mt-4 grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $coach->name) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" id="role"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">— Select —</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" {{ old('role', $coach->role) === $role ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="team" class="block text-sm font-medium text-gray-700">Team</label>
                                <input type="text" name="team" id="team" value="{{ old('team', $coach->team) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('team')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="experience_years" class="block text-sm font-medium text-gray-700">Experience (Years)</label>
                                <input type="number" name="experience_years" id="experience_years" value="{{ old('experience_years', $coach->experience_years) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('experience_years')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Contact</h3>
                        <div class="mt-4 grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $coach->email) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $coach->phone) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('coaches.show', $coach) }}" class="text-sm text-gray-600 hover:text-gray-900">
                            Cancel
                        </a>

                        <button type="submit"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white text-sm font-medium hover:bg-indigo-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>