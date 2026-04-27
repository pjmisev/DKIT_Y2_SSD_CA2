<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('players.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Player</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">

                @php $user = $profile->user; $info = $profile->profileable; @endphp

                <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-100">
                    @if ($profile->image)
                        <img src="{{ Storage::url($profile->image) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-xl object-cover">
                    @else
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                        <div class="text-sm text-gray-400">{{ $user->email }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('players.update', $profile) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Account Information -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Account Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-400 @enderror">
                                @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-400 @enderror">
                                @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">New Password <span class="text-gray-400 font-normal">(leave blank to keep)</span></label>
                                <input type="password" name="password" id="password"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-400 @enderror">
                                @error('password') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="salary" class="block text-sm font-semibold text-gray-700 mb-1.5">Salary (€)</label>
                                <input type="number" name="salary" id="salary" value="{{ old('salary', $user->salary) }}" min="0"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('salary') border-red-400 @enderror">
                                @error('salary') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="flex items-center gap-3 mt-6 cursor-pointer">
                                    <input type="checkbox" name="status" value="1" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('status', $user->status) ? 'checked' : '' }}>
                                    <span class="text-sm font-semibold text-gray-700">Active account</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Player Profile -->
                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Player Profile</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="jersey_number" class="block text-sm font-semibold text-gray-700 mb-1.5">Jersey Number</label>
                                <input type="number" name="jersey_number" id="jersey_number" value="{{ old('jersey_number', $info->jersey_number) }}" min="0" max="99"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="position" class="block text-sm font-semibold text-gray-700 mb-1.5">Position</label>
                                <select name="position" id="position"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select position</option>
                                    @foreach ($positions as $pos)
                                        <option value="{{ $pos }}" {{ old('position', $info->position) === $pos ? 'selected' : '' }}>{{ $pos }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="dominant_hand" class="block text-sm font-semibold text-gray-700 mb-1.5">Dominant Hand</label>
                                <select name="dominant_hand" id="dominant_hand"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select</option>
                                    <option value="left" {{ old('dominant_hand', $info->dominant_hand) === 'left' ? 'selected' : '' }}>Left</option>
                                    <option value="right" {{ old('dominant_hand', $info->dominant_hand) === 'right' ? 'selected' : '' }}>Right</option>
                                </select>
                            </div>

                            <div>
                                <label for="health_status" class="block text-sm font-semibold text-gray-700 mb-1.5">Health Status <span class="text-red-500">*</span></label>
                                <select name="health_status" id="health_status" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach ($healthStatuses as $hs)
                                        <option value="{{ $hs }}" {{ old('health_status', $info->health_status) === $hs ? 'selected' : '' }}>{{ ucfirst($hs) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="height_cm" class="block text-sm font-semibold text-gray-700 mb-1.5">Height (cm)</label>
                                <input type="number" name="height_cm" id="height_cm" value="{{ old('height_cm', $info->height_cm) }}" min="100" max="250"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="weight_kg" class="block text-sm font-semibold text-gray-700 mb-1.5">Weight (kg)</label>
                                <input type="number" name="weight_kg" id="weight_kg" value="{{ old('weight_kg', $info->weight_kg) }}" min="30" max="200"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="team" class="block text-sm font-semibold text-gray-700 mb-1.5">Team</label>
                                <input type="text" name="team" id="team" value="{{ old('team', $profile->team) }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="nationality" class="block text-sm font-semibold text-gray-700 mb-1.5">Nationality</label>
                                <input type="text" name="nationality" id="nationality" value="{{ old('nationality', $profile->nationality) }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 mb-1.5">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-semibold text-gray-700 mb-1.5">Photo</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @if ($profile->image)
                                    <p class="mt-1 text-xs text-gray-400">Current photo exists. Upload a new one to replace it.</p>
                                @endif
                                @error('image') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1.5">Notes</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $profile->notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('players.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
