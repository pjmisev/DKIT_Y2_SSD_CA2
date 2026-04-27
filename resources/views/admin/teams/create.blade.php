<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.teams.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Team</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <form method="POST" action="{{ route('admin.teams.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Team Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-violet-500 focus:ring-violet-500 @error('name') border-red-400 @enderror"
                            placeholder="e.g. Boston Celtics">
                        @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="theme_color" class="block text-sm font-semibold text-gray-700 mb-1.5">Theme Colour <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-4">
                            <input type="color" name="theme_color" id="color_picker" value="{{ old('theme_color', '#ea580c') }}" required
                                class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-0.5">
                            <input type="text" id="hex_input" value="{{ old('theme_color', '#ea580c') }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-violet-500 focus:ring-violet-500 font-mono uppercase @error('theme_color') border-red-400 @enderror"
                                placeholder="#EA580C" maxlength="7">
                        </div>
                        @error('theme_color') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1.5 text-xs text-gray-400">This colour will replace the orange accent throughout the app for users on this team.</p>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('admin.teams.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="inline-flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                            Create Team
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('color_picker').addEventListener('input', function() {
            document.getElementById('hex_input').value = this.value.toUpperCase();
        });

        document.getElementById('hex_input').addEventListener('input', function() {
            const val = this.value.trim();
            if (/^#[a-fA-F0-9]{6}$/.test(val)) {
                document.getElementById('color_picker').value = val.toLowerCase();
            }
        });
    </script>
    @endpush
</x-app-layout>
