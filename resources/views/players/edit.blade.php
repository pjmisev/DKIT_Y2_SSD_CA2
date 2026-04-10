<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('players.show', $player) }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Player</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <form method="POST" action="{{ route('players.update', $player) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Identity --}}
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Identity</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $player->name) }}" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-400 @enderror">
                                @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-2">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $player->email) }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-400 @enderror">
                                @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="jersey_number" class="block text-sm font-semibold text-gray-700 mb-1.5">Jersey #</label>
                                <input type="number" name="jersey_number" id="jersey_number" value="{{ old('jersey_number', $player->jersey_number) }}" min="0" max="99"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jersey_number') border-red-400 @enderror">
                                @error('jersey_number') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 mb-1.5">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $player->date_of_birth?->format('Y-m-d')) }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('date_of_birth') border-red-400 @enderror">
                                @error('date_of_birth') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="nationality" class="block text-sm font-semibold text-gray-700 mb-1.5">Nationality</label>
                                <input type="text" name="nationality" id="nationality" value="{{ old('nationality', $player->nationality) }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="dominant_hand" class="block text-sm font-semibold text-gray-700 mb-1.5">Dominant Hand</label>
                                <select name="dominant_hand" id="dominant_hand"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">— Select —</option>
                                    <option value="right" {{ old('dominant_hand', $player->dominant_hand) === 'right' ? 'selected' : '' }}>Right</option>
                                    <option value="left"  {{ old('dominant_hand', $player->dominant_hand) === 'left'  ? 'selected' : '' }}>Left</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Basketball --}}
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Basketball</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="position" class="block text-sm font-semibold text-gray-700 mb-1.5">Position</label>
                                <select name="position" id="position"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">— Select —</option>
                                    @foreach ($positions as $pos)
                                        <option value="{{ $pos }}" {{ old('position', $player->position) === $pos ? 'selected' : '' }}>{{ $pos }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="team" class="block text-sm font-semibold text-gray-700 mb-1.5">Team</label>
                                <input type="text" name="team" id="team" value="{{ old('team', $player->team) }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    {{-- Physical --}}
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Physical</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="height_cm" class="block text-sm font-semibold text-gray-700 mb-1.5">Height (cm)</label>
                                <input type="number" name="height_cm" id="height_cm" value="{{ old('height_cm', $player->height_cm) }}" min="100" max="250"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('height_cm') border-red-400 @enderror">
                                @error('height_cm') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="weight_kg" class="block text-sm font-semibold text-gray-700 mb-1.5">Weight (kg)</label>
                                <input type="number" name="weight_kg" id="weight_kg" value="{{ old('weight_kg', $player->weight_kg) }}" min="30" max="200"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('weight_kg') border-red-400 @enderror">
                                @error('weight_kg') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Contract --}}
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Contract</h3>
                        <div>
                            <label for="salary" class="block text-sm font-semibold text-gray-700 mb-1.5">Salary (€)</label>
                            <input type="number" name="salary" id="salary" value="{{ old('salary', $player->salary) }}" min="0"
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('salary') border-red-400 @enderror">
                            @error('salary') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Health --}}
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Health</h3>
                        <div>
                            <label for="health_status" class="block text-sm font-semibold text-gray-700 mb-1.5">Health Status <span class="text-red-500">*</span></label>
                            <select name="health_status" id="health_status" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach ($healthStatuses as $status)
                                    <option value="{{ $status }}" {{ old('health_status', $player->health_status) === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1.5">Notes</label>
                            <textarea name="notes" id="notes" rows="3" placeholder="Injuries, conditions, return dates..."
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $player->notes) }}</textarea>
                        </div>
                    </div>

                    {{-- Photo --}}
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Photo</h3>
                        <div>
                            @if ($player->image)
                                <div class="mb-3">
                                    <img src="{{ Storage::url($player->image) }}" alt="{{ $player->name }}" class="w-20 h-20 rounded-xl object-cover">
                                    <p class="text-xs text-gray-400 mt-1">Current photo — upload a new one to replace it.</p>
                                </div>
                            @endif
                            <label for="image" class="block text-sm font-semibold text-gray-700 mb-1.5">Profile Image</label>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border border-red-400 rounded-lg @enderror">
                            @error('image') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Linked User --}}
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Linked Account</h3>
                        <div>
                            <label for="linked_to" class="block text-sm font-semibold text-gray-700 mb-1.5">User Account</label>
                            <select name="linked_to" id="linked_to"
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('linked_to') border-red-400 @enderror">
                                <option value="">— Select a user —</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('linked_to', $player->linked_to) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('linked_to') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                        <a href="{{ route('players.show', $player) }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
