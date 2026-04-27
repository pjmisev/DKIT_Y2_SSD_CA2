<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('events.index') }}" class="page-header-back">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $event->name }}</h2>
                    <p class="text-sm text-gray-500">Event details</p>
                </div>
            </div>
            @if (Auth::user()->isAdmin())
                <div class="flex items-center gap-3">
                    <a href="{{ route('events.edit', $event) }}" class="btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                    <form method="POST" action="{{ route('events.destroy', $event) }}" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this event?')" class="btn-danger">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-soft overflow-hidden">
                <!-- Date banner -->
                <div class="bg-gradient-to-r from-hoop-500 to-hoop-600 px-8 py-8 text-white">
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-sm font-semibold uppercase opacity-75">{{ $event->start_time->format('l') }}</div>
                            <div class="text-5xl font-black leading-none mt-1">{{ $event->start_time->format('d') }}</div>
                            <div class="text-sm font-semibold uppercase opacity-75 mt-1">{{ $event->start_time->format('M Y') }}</div>
                        </div>
                        <div class="border-l border-white/30 pl-6">
                            <div class="text-xl font-bold">{{ $event->name }}</div>
                            <div class="text-sm opacity-80 mt-1.5 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $event->start_time->format('g:i A') }} – {{ $event->end_time->format('g:i A') }}
                            </div>
                            @if ($event->location)
                                <div class="flex items-center gap-1.5 mt-2 text-sm opacity-80">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $event->location }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6">
                    @if ($event->description)
                        <div class="mb-6">
                            <h3 class="section-header text-sm">Description</h3>
                            <p class="text-gray-600 leading-relaxed text-sm">{{ $event->description }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-6 text-sm">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Start</span>
                            <p class="mt-1 font-semibold text-gray-800">{{ $event->start_time->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">End</span>
                            <p class="mt-1 font-semibold text-gray-800">{{ $event->end_time->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Created By</span>
                            <p class="mt-1 font-semibold text-gray-800">{{ $event->creator?->name ?? '—' }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</span>
                            <p class="mt-1">
                                @if ($event->end_time->isPast())
                                    <span class="badge badge-gray">Past</span>
                                @else
                                    <span class="badge badge-hoop">Upcoming</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Google Map --}}
                    @if ($event->latitude && $event->longitude)
                        <div class="mt-8">
                            <h3 class="section-header text-sm">Location</h3>
                            <div id="event-map" class="w-full h-72 rounded-xl border border-gray-200"></div>
                            <div class="mt-3 flex items-center justify-between">
                                <p class="text-sm text-gray-500">{{ $event->location }}</p>
                                <a href="{{ $event->map_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-semibold text-hoop-600 hover:text-hoop-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    Open in Google Maps
                                </a>
                            </div>
                        </div>
                    @elseif ($event->location)
                        <div class="mt-8">
                            <h3 class="section-header text-sm">Location</h3>
                            <div class="flex items-center justify-between bg-gray-50 rounded-xl px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="text-sm text-gray-700 font-medium">{{ $event->location }}</span>
                                </div>
                                <a href="{{ $event->map_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-semibold text-hoop-600 hover:text-hoop-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    Open in Google Maps
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($event->latitude && $event->longitude)
    @push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lat = {{ $event->latitude }};
            const lng = {{ $event->longitude }};

            const map = L.map('event-map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup('<strong>{{ addslashes($event->location ?? $event->name) }}</strong>')
                .openPopup();
        });
    </script>
    @endpush
    @endif
</x-app-layout>
