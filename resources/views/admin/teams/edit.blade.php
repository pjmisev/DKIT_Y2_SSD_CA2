<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.teams.index') }}" class="page-header-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Team</h2>
                <p class="text-sm text-gray-500">Update team details</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-soft p-8">
                <form method="POST" action="{{ route('admin.teams.update', $team) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="name" class="form-label">Team Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $team->name) }}" required
                            class="input-field @error('name') border-red-400 @enderror">
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="input-field @error('description') border-red-400 @enderror">{{ old('description', $team->description) }}</textarea>
                        @error('description') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.teams.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Update Team
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
