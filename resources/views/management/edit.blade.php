<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('management.index') }}" class="page-header-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Management</h2>
                <p class="text-sm text-gray-500">Update management member details</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-soft p-8">
                <form method="POST" action="{{ route('management.update', $management) }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PATCH')

                    <!-- Account Information -->
                    <div>
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-sky-500 to-sky-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Account Information</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="name" class="form-label">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $management->user->name) }}" required
                                    class="input-field @error('name') border-red-400 @enderror">
                                @error('name') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $management->user->email) }}" required
                                    class="input-field @error('email') border-red-400 @enderror">
                                @error('email') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password" class="form-label">New Password <span class="text-xs text-gray-400">(leave blank to keep current)</span></label>
                                <input type="password" name="password" id="password"
                                    class="input-field @error('password') border-red-400 @enderror">
                                @error('password') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="input-field">
                            </div>

                            <div>
                                <label for="salary" class="form-label">Salary (€)</label>
                                <input type="number" name="salary" id="salary" value="{{ old('salary', $management->user->salary) }}" min="0"
                                    class="input-field @error('salary') border-red-400 @enderror">
                                @error('salary') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="flex items-center gap-3 mt-6 cursor-pointer select-none">
                                    <input type="checkbox" name="status" value="1" {{ old('status', $management->user->status) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                                    <span class="text-sm font-semibold text-gray-700">Active account</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Management Profile -->
                    <div>
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-sky-500 to-sky-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Management Profile</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="role_title" class="form-label">Role Title</label>
                                <input type="text" name="role_title" id="role_title" value="{{ old('role_title', $management->info->role_title) }}"
                                    class="input-field @error('role_title') border-red-400 @enderror">
                                @error('role_title') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="department" class="form-label">Department</label>
                                <input type="text" name="department" id="department" value="{{ old('department', $management->info->department) }}"
                                    class="input-field @error('department') border-red-400 @enderror">
                                @error('department') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="team" class="form-label">Team</label>
                                <input type="text" name="team" id="team" value="{{ old('team', $management->info->team) }}"
                                    class="input-field">
                            </div>

                            <div>
                                <label for="nationality" class="form-label">Nationality</label>
                                <input type="text" name="nationality" id="nationality" value="{{ old('nationality', $management->info->nationality) }}"
                                    class="input-field">
                            </div>

                            <div>
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $management->info->date_of_birth?->format('Y-m-d')) }}"
                                    class="input-field @error('date_of_birth') border-red-400 @enderror">
                                @error('date_of_birth') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="image" class="form-label">Photo</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                                @error('image') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="input-field">{{ old('notes', $management->info->notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('management.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #0ea5e9, #0284c7);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Update Management
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
