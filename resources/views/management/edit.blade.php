<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('management.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Management Member</h2>
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
                        <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center text-sky-600 font-bold text-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                        <div class="text-sm text-gray-400">{{ $user->email }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('management.update', $profile) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf @method('PATCH')

                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Account Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>
                            <div class="col-span-2">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">New Password <span class="text-gray-400 font-normal">(leave blank)</span></label>
                                <input type="password" name="password" id="password"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>
                            <div>
                                <label for="salary" class="block text-sm font-semibold text-gray-700 mb-1.5">Salary (€)</label>
                                <input type="number" name="salary" id="salary" value="{{ old('salary', $user->salary) }}" min="0"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>
                            <div>
                                <label class="flex items-center gap-3 mt-6 cursor-pointer">
                                    <input type="checkbox" name="status" value="1" class="w-4 h-4 rounded border-gray-300 text-sky-600 focus:ring-sky-500" {{ old('status', $user->status) ? 'checked' : '' }}>
                                    <span class="text-sm font-semibold text-gray-700">Active account</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Management Profile</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="role" class="block text-sm font-semibold text-gray-700 mb-1.5">Role</label>
                                <select name="role" id="role"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500">
                                    <option value="">Select role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" {{ old('role', $info->role) === $role ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="team" class="block text-sm font-semibold text-gray-700 mb-1.5">Team</label>
                                <input type="text" name="team" id="team" value="{{ old('team', $profile->team) }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>
                            <div>
                                <label for="nationality" class="block text-sm font-semibold text-gray-700 mb-1.5">Nationality</label>
                                <input type="text" name="nationality" id="nationality" value="{{ old('nationality', $profile->nationality) }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>
                            <div>
                                <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 mb-1.5">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>
                            <div>
                                <label for="image" class="block text-sm font-semibold text-gray-700 mb-1.5">Photo</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                                @if ($profile->image)
                                    <p class="mt-1 text-xs text-gray-400">Current photo exists.</p>
                                @endif
                            </div>
                            <div class="col-span-2">
                                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1.5">Notes</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-sky-500 focus:ring-sky-500">{{ old('notes', $profile->notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('management.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
