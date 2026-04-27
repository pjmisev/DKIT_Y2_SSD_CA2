<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('events.show', $event) }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Event</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <form method="POST" action="{{ route('events.update', $event) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Event Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-orange-500 focus:ring-orange-500 @error('name') border-red-400 @enderror">
                        @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-orange-500 focus:ring-orange-500 @error('description') border-red-400 @enderror">{{ old('description', $event->description) }}</textarea>
                        @error('description') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-1.5">Start <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="start_time" id="start_time"
                                value="{{ old('start_time', $event->start_time->format('Y-m-d\TH:i')) }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-orange-500 focus:ring-orange-500 @error('start_time') border-red-400 @enderror">
                            @error('start_time') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-1.5">End <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="end_time" id="end_time"
                                value="{{ old('end_time', $event->end_time->format('Y-m-d\TH:i')) }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-orange-500 focus:ring-orange-500 @error('end_time') border-red-400 @enderror">
                            @error('end_time') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Location with Map Picker --}}
                    <div x-data="locationPicker()">
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-1.5">Location</label>
                        <div class="relative">
                            <input type="text" name="location" id="location" x-model="searchQuery" x-on:input.debounce.500ms="searchLocation()"
                                placeholder="Search for a place or drag the pin on the map..."
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-orange-500 focus:ring-orange-500 @error('location') border-red-400 @enderror">
                            @error('location') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Search results dropdown --}}
                        <div x-show="results.length > 0" x-cloak
                            class="mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                            <template x-for="(result, index) in results" :key="index">
                                <button type="button" x-on:click="selectResult(result)"
                                    class="w-full text-left px-4 py-2.5 text-sm hover:bg-orange-50 border-b border-gray-100 last:border-b-0 transition-colors">
                                    <span class="font-medium text-gray-800" x-text="result.display_name"></span>
                                </button>
                            </template>
                        </div>

                        {{-- Map -- always visible so users can drag the pin --}}
                        <div class="mt-3">
                            <div id="map-picker" class="w-full h-72 rounded-lg border border-gray-200"></div>
                            <p class="mt-1.5 text-xs text-gray-400">Drag the pin to set the location, or search above.</p>
                        </div>

                        {{-- Selected location info --}}
                        <div x-show="selectedAddress" x-cloak class="mt-2 flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span x-text="selectedAddress" class="flex-1"></span>
                            <button type="button" x-on:click="clearLocation()" class="text-red-500 hover:text-red-700 font-medium text-xs">Remove</button>
                        </div>

                        {{-- Hidden inputs for lat/lng --}}
                        <input type="hidden" name="latitude" x-model="selectedLat">
                        <input type="hidden" name="longitude" x-model="selectedLng">
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('events.show', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function locationPicker() {
            return {
                searchQuery: '{{ old('location', $event->location) }}',
                results: [],
                selectedLat: '{{ old('latitude', $event->latitude) }}',
                selectedLng: '{{ old('longitude', $event->longitude) }}',
                selectedAddress: '{{ old('location', $event->location) }}',
                map: null,
                marker: null,
                mapInitialized: false,

                init() {
                    this.$nextTick(() => this.initMap());
                },

                async searchLocation() {
                    if (!this.searchQuery || this.searchQuery.length < 3) {
                        this.results = [];
                        return;
                    }

                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}&limit=5&addressdetails=1`);
                        this.results = await response.json();
                    } catch (e) {
                        console.error('Search failed:', e);
                    }
                },

                selectResult(result) {
                    this.searchQuery = result.display_name;
                    this.selectedAddress = result.display_name;
                    this.selectedLat = result.lat;
                    this.selectedLng = result.lon;
                    this.results = [];

                    this.updateMarker();
                },

                initMap() {
                    const mapDiv = document.getElementById('map-picker');
                    if (!mapDiv || this.mapInitialized) return;
                    this.mapInitialized = true;

                    // Default to event location if set, otherwise Ireland / Dublin
                    const defaultLat = 53.3498;
                    const defaultLng = -6.2603;
                    const lat = this.selectedLat ? parseFloat(this.selectedLat) : defaultLat;
                    const lng = this.selectedLng ? parseFloat(this.selectedLng) : defaultLng;

                    this.map = L.map(mapDiv, {
                        zoomControl: true,
                        scrollWheelZoom: true
                    }).setView([lat, lng], this.selectedLat ? 15 : 12);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(this.map);

                    this.marker = L.marker([lat, lng], { draggable: true }).addTo(this.map);

                    // If no location was pre-set, set the default coords
                    if (!this.selectedLat || !this.selectedLng) {
                        this.selectedLat = lat.toFixed(7);
                        this.selectedLng = lng.toFixed(7);
                        this.reverseGeocode(lat, lng);
                    }

                    this.marker.on('dragend', (e) => {
                        const pos = e.target.getLatLng();
                        this.selectedLat = pos.lat.toFixed(7);
                        this.selectedLng = pos.lng.toFixed(7);
                        this.reverseGeocode(pos.lat, pos.lng);
                    });

                    // Also allow clicking on the map to move the pin
                    this.map.on('click', (e) => {
                        this.marker.setLatLng(e.latlng);
                        this.selectedLat = e.latlng.lat.toFixed(7);
                        this.selectedLng = e.latlng.lng.toFixed(7);
                        this.reverseGeocode(e.latlng.lat, e.latlng.lng);
                    });

                    // Fix map rendering after Alpine finishes
                    setTimeout(() => this.map.invalidateSize(), 100);
                },

                updateMarker() {
                    if (!this.map || !this.marker) {
                        this.initMap();
                        return;
                    }

                    const lat = parseFloat(this.selectedLat);
                    const lng = parseFloat(this.selectedLng);

                    this.marker.setLatLng([lat, lng]);
                    this.map.setView([lat, lng], 15);
                },

                async reverseGeocode(lat, lng) {
                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                        const data = await response.json();
                        if (data.display_name) {
                            this.searchQuery = data.display_name;
                            this.selectedAddress = data.display_name;
                        }
                    } catch (e) {
                        console.error('Reverse geocode failed:', e);
                    }
                },

                clearLocation() {
                    this.searchQuery = '';
                    this.selectedLat = '';
                    this.selectedLng = '';
                    this.selectedAddress = '';
                    this.results = [];

                    // Reset marker to default position
                    if (this.map && this.marker) {
                        const defaultLat = 53.3498;
                        const defaultLng = -6.2603;
                        this.marker.setLatLng([defaultLat, defaultLng]);
                        this.map.setView([defaultLat, defaultLng], 12);
                    }
                }
            }
        }
    </script>
    @endpush

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>
