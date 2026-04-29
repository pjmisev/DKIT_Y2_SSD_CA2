<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('players.index') }}" class="page-header-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Edit Player</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Update player details</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-soft p-8">
                <form method="POST" action="{{ route('players.update', $player) }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PATCH')

                    <!-- Account Information -->
                    <div>
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wider">Account Information</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="name" class="form-label">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $player->user->name) }}" required
                                    class="input-field @error('name') border-red-400 @enderror">
                                @error('name') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $player->user->email) }}" required
                                    class="input-field @error('email') border-red-400 @enderror">
                                @error('email') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password" class="form-label">New Password <span class="text-xs text-gray-400 dark:text-gray-500">(leave blank to keep current)</span></label>
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
                                <input type="number" name="salary" id="salary" value="{{ old('salary', $player->user->salary) }}" min="0"
                                    class="input-field @error('salary') border-red-400 @enderror">
                                @error('salary') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="flex items-center gap-3 mt-6 cursor-pointer select-none">
                                    <input type="checkbox" name="status" value="1" {{ old('status', $player->user->status) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active account</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Player Profile -->
                    <div>
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wider">Player Profile</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="jersey_number" class="form-label">Jersey Number</label>
                                <input type="number" name="jersey_number" id="jersey_number" value="{{ old('jersey_number', $player->profileable->jersey_number) }}" min="0" max="99"
                                    class="input-field @error('jersey_number') border-red-400 @enderror">
                                @error('jersey_number') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="position" class="form-label">Position</label>
                                <select name="position" id="position"
                                    class="input-field @error('position') border-red-400 @enderror">
                                    <option value="">Select position</option>
                                    @foreach ($positions as $pos)
                                        <option value="{{ $pos }}" {{ old('position', $player->profileable->position) === $pos ? 'selected' : '' }}>{{ $pos }}</option>
                                    @endforeach
                                </select>
                                @error('position') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="dominant_hand" class="form-label">Dominant Hand</label>
                                <select name="dominant_hand" id="dominant_hand" class="input-field">
                                    <option value="">Select</option>
                                    <option value="left" {{ old('dominant_hand', $player->profileable->dominant_hand) === 'left' ? 'selected' : '' }}>Left</option>
                                    <option value="right" {{ old('dominant_hand', $player->profileable->dominant_hand) === 'right' ? 'selected' : '' }}>Right</option>
                                </select>
                            </div>

                            <div>
                                <label for="health_status" class="form-label">Health Status <span class="text-red-500">*</span></label>
                                <select name="health_status" id="health_status" required
                                    class="input-field @error('health_status') border-red-400 @enderror">
                                    @foreach ($healthStatuses as $hs)
                                        <option value="{{ $hs }}" {{ old('health_status', $player->profileable->health_status) === $hs ? 'selected' : '' }}>{{ ucfirst($hs) }}</option>
                                    @endforeach
                                </select>
                                @error('health_status') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="height_cm" class="form-label">Height (cm)</label>
                                <input type="number" name="height_cm" id="height_cm" value="{{ old('height_cm', $player->profileable->height_cm) }}" min="100" max="250"
                                    class="input-field">
                            </div>

                            <div>
                                <label for="weight_kg" class="form-label">Weight (kg)</label>
                                <input type="number" name="weight_kg" id="weight_kg" value="{{ old('weight_kg', $player->profileable->weight_kg) }}" min="30" max="200"
                                    class="input-field">
                            </div>

                            <div>
                                <label for="team" class="form-label">Team</label>
                                <input type="text" name="team" id="team" value="{{ old('team', $player->team) }}"
                                    class="input-field">
                            </div>

                            <div>
                                <label for="nationality" class="form-label">Nationality</label>
                                <input type="text" name="nationality" id="nationality" value="{{ old('nationality', $player->nationality) }}"
                                    class="input-field">
                            </div>

                            <div>
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $player->date_of_birth?->format('Y-m-d')) }}"
                                    class="input-field @error('date_of_birth') border-red-400 @enderror">
                                @error('date_of_birth') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="image" class="form-label">Photo</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/50 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800/50">
                                @error('image') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="input-field">{{ old('notes', $player->notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('players.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Update Player
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
