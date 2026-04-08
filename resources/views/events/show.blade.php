<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('events.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $event->name }}</h2>
            </div>
            @if (Auth::user()->isAdmin())
                <div class="flex items-center gap-3">
                    <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">Edit</a>
                    <form method="POST" action="{{ route('events.destroy', $event) }}">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this event?')" class="inline-flex items-center bg-white hover:bg-red-50 text-red-600 border border-red-200 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">Delete</button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <!-- Date banner -->
                <div class="bg-orange-500 px-8 py-6 text-white">
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-sm font-semibold uppercase opacity-75">{{ $event->start_time->format('l') }}</div>
                            <div class="text-5xl font-black leading-none">{{ $event->start_time->format('d') }}</div>
                            <div class="text-sm font-semibold uppercase opacity-75">{{ $event->start_time->format('M Y') }}</div>
                        </div>
                        <div class="border-l border-orange-400 pl-6">
                            <div class="text-lg font-bold">{{ $event->name }}</div>
                            <div class="text-sm opacity-80 mt-1">{{ $event->start_time->format('g:i A') }} – {{ $event->end_time->format('g:i A') }}</div>
                            @if ($event->location)
                                <div class="flex items-center gap-1.5 mt-1 text-sm opacity-80">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $event->location }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6">
                    @if ($event->description)
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Description</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $event->description }}</p>
                        </div>
                    @endif

                    <dl class="grid grid-cols-2 gap-6 text-sm">
                        <div>
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Start</dt>
                            <dd class="mt-1 font-medium text-gray-800">{{ $event->start_time->format('M d, Y \a\t g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">End</dt>
                            <dd class="mt-1 font-medium text-gray-800">{{ $event->end_time->format('M d, Y \a\t g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Created By</dt>
                            <dd class="mt-1 font-medium text-gray-800">{{ $event->creator?->name ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</dt>
                            <dd class="mt-1">
                                @if ($event->end_time->isPast())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Past</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">Upcoming</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
