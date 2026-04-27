<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('coaches.index') }}" class="page-header-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Coach</h2>
                <p class="text-sm text-gray-500">Update coach details</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-soft p-8">
                <form method="POST" action="{{ route('coaches.update', $coach) }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PATCH')

                    <!-- Account Information -->
                    <div>
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Account Information</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="name" class="form-label">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $coach->user->name) }}" required
                                    class="input-field @error('name') border-red-400 @enderror">
                                @error('name') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $coach->user->email) }}" required
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
                                <input type="number" name="salary" id="salary" value="{{ old('salary', $coach->user->salary) }}" min="0"
                                    class="input-field @error('salary') border-red-400 @enderror">
                                @error('salary') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="flex items-center gap-3 mt-6 cursor-pointer select-none">
                                    <input type="checkbox" name="status" value="1" {{ old('status', $coach->user->status) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-sm font-semibold text-gray-700">Active account</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Coach Profile -->
                    <div>
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Coach Profile</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="specialization" class="form-label">Specialization</label>
                                <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $coach->info->specialization) }}"
                                    class="input-field @error('specialization') border-red-400 @enderror">
                                @error('specialization') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="experience_years" class="form-label">Experience (years)</label>
                                <input type="number" name="experience_years" id="experience_years" value="{{ old('experience_years', $coach->info->experience_years) }}" min="0"
                                    class="input-field @error('experience_years') border-red-400 @enderror">
                                @error('experience_years') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="team" class="form-label">Team</label>
                                <input type="text" name="team" id="team" value="{{ old('team', $coach->info->team) }}"
                                    class="input-field">
                            </div>

                            <div>
                                <label for="nationality" class="form-label">Nationality</label>
                                <input type="text" name="nationality" id="nationality" value="{{ old('nationality', $coach->info->nationality) }}"
                                    class="input-field">
                            </div>

                            <div>
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $coach->info->date_of_birth?->format('Y-m-d')) }}"
                                    class="input-field @error('date_of_birth') border-red-400 @enderror">
                                @error('date_of_birth') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="image" class="form-label">Photo</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                @error('image') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="input-field">{{ old('notes', $coach->info->notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('coaches.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #059669, #047857);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Update Coach
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
