<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="page-header-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Create User</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Add a new user to the system</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-soft p-8">
                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="form-label">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="input-field @error('name') border-red-400 @enderror">
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="input-field @error('email') border-red-400 @enderror">
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="form-label">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password" required
                                class="input-field @error('password') border-red-400 @enderror">
                            @error('password') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="input-field">
                        </div>
                    </div>

                    <div>
                        <label for="role" class="form-label">Role <span class="text-red-500">*</span></label>
                        <select name="role" id="role" required
                            class="input-field @error('role') border-red-400 @enderror">
                            <option value="">Select role</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="player" {{ old('role') === 'player' ? 'selected' : '' }}>Player</option>
                            <option value="coach" {{ old('role') === 'coach' ? 'selected' : '' }}>Coach</option>
                            <option value="management" {{ old('role') === 'management' ? 'selected' : '' }}>Management</option>
                        </select>
                        @error('role') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="salary" class="form-label">Salary (€)</label>
                        <input type="number" name="salary" id="salary" value="{{ old('salary', 0) }}" min="0"
                            class="input-field @error('salary') border-red-400 @enderror">
                        @error('salary') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <input type="checkbox" name="status" value="1" checked
                                class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-hoop-600 focus:ring-hoop-500">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active account</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
