<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('events.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Event</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <form method="POST" action="{{ route('events.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Event Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-orange-500 focus:ring-orange-500 @error('name') border-red-400 @enderror">
                        @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-orange-500 focus:ring-orange-500 @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-1.5">Start <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-orange-500 focus:ring-orange-500 @error('start_time') border-red-400 @enderror">
                            @error('start_time') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-1.5">End <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-orange-500 focus:ring-orange-500 @error('end_time') border-red-400 @enderror">
                            @error('end_time') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-1.5">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-orange-500 focus:ring-orange-500 @error('location') border-red-400 @enderror">
                        @error('location') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('events.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                            Create Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
