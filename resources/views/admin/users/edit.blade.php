<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">

                <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-violet-100 flex items-center justify-center text-violet-600 font-bold text-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                        <div class="text-sm text-gray-400">{{ $user->email }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-violet-500 focus:ring-violet-500 @error('name') border-red-400 @enderror">
                            @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-violet-500 focus:ring-violet-500 @error('email') border-red-400 @enderror">
                            @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">New Password <span class="text-gray-400 font-normal">(leave blank to keep)</span></label>
                            <input type="password" name="password" id="password"
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-violet-500 focus:ring-violet-500 @error('password') border-red-400 @enderror">
                            @error('password') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-semibold text-gray-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                            <select name="role" id="role" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-violet-500 focus:ring-violet-500 @error('role') border-red-400 @enderror">
                                @foreach (['admin', 'coach', 'player', 'staff'] as $role)
                                    <option value="{{ $role }}" {{ old('role', $user->role) === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                            @error('role') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-semibold text-gray-700 mb-1.5">Position</label>
                            <input type="text" name="position" id="position" value="{{ old('position', $user->position) }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-violet-500 focus:ring-violet-500 @error('position') border-red-400 @enderror">
                            @error('position') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-2">
                            <label for="team_id" class="block text-sm font-semibold text-gray-700 mb-1.5">Team</label>
                            <select name="team_id" id="team_id"
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-violet-500 focus:ring-violet-500 @error('team_id') border-red-400 @enderror">
                                <option value="">— No Team —</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" {{ old('team_id', $user->team_id) == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('team_id') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-2">
                            <label for="salary" class="block text-sm font-semibold text-gray-700 mb-1.5">Salary (€) <span class="text-red-500">*</span></label>
                            <input type="number" name="salary" id="salary" value="{{ old('salary', $user->salary) }}" min="0" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-violet-500 focus:ring-violet-500 @error('salary') border-red-400 @enderror">
                            @error('salary') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="status" value="1" class="w-4 h-4 rounded border-gray-300 text-violet-600 focus:ring-violet-500" {{ old('status', $user->status) ? 'checked' : '' }}>
                                <span class="text-sm font-semibold text-gray-700">Active account</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="inline-flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
