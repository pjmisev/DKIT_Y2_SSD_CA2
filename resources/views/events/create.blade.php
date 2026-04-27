<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('events.index') }}" class="page-header-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Event</h2>
                <p class="text-sm text-gray-500">Schedule a new event</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-soft p-8">
                <form method="POST" action="{{ route('events.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="form-label">Event Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="input-field @error('name') border-red-400 @enderror">
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="input-field @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                        @error('description') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_time" class="form-label">Start <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}" required
                                class="input-field @error('start_time') border-red-400 @enderror">
                            @error('start_time') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_time" class="form-label">End <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}" required
                                class="input-field @error('end_time') border-red-400 @enderror">
                            @error('end_time') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Location with Map Picker --}}
                    <div x-data="locationPicker()">
                        <label for="location" class="form-label">Location</label>
                        <div class="relative">
                            <input type="text" name="location" id="location" x-model="searchQuery" x-on:input.debounce.500ms="searchLocation()"
                                placeholder="Search for a place or drag the pin on the map..."
                                class="input-field @error('location') border-red-400 @enderror">
                            @error('location') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        {{-- Search results dropdown --}}
                        <div x-show="results.length > 0" x-cloak
                            class="mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-48 overflow-y-auto">
                            <template x-for="(result, index) in results" :key="index">
                                <button type="button" x-on:click="selectResult(result)"
                                    class="w-full text-left px-4 py-2.5 text-sm hover:bg-hoop-50 border-b border-gray-100 last:border-b-0 transition-colors">
                                    <span class="font-medium text-gray-800" x-text="result.display_name"></span>
                                </button>
                            </template>
                        </div>

                        {{-- Map --}}
                        <div class="mt-3">
                            <div id="map-picker" class="w-full h-72 rounded-xl border border-gray-200"></div>
                            <p class="mt-1.5 text-xs text-gray-400">Drag the pin to set the location, or search above.</p>
                        </div>

                        {{-- Selected location info --}}
                        <div x-show="selectedAddress" x-cloak class="mt-2 flex items-center gap-2 text-sm text-gray-600 bg-hoop-50 rounded-xl px-4 py-3">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span x-text="selectedAddress" class="flex-1"></span>
                            <button type="button" x-on:click="clearLocation()" class="text-red-500 hover:text-red-700 font-medium text-xs">Remove</button>
                        </div>

                        {{-- Hidden inputs for lat/lng --}}
                        <input type="hidden" name="latitude" x-model="selectedLat">
                        <input type="hidden" name="longitude" x-model="selectedLng">
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('events.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Create Event
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
                searchQuery: '{{ old('location') }}',
                results: [],
                selectedLat: '{{ old('latitude') }}',
                selectedLng: '{{ old('longitude') }}',
                selectedAddress: '',
                map: null,
                marker: null,
                mapInitialized: false,

                init() {
                    this.$nextTick(() => this.initMap());

                    if (this.selectedLat && this.selectedLng) {
                        this.selectedAddress = this.searchQuery;
                    }
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

                    const defaultLat = 53.3498;
                    const defaultLng = -6.2603;
                    const lat = this.selectedLat ? parseFloat(this.selectedLat) : defaultLat;
                    const lng = this.selectedLng ? parseFloat(this.selectedLng) : defaultLng;

                    this.map = L.map(mapDiv, {
                        zoomControl: true,
                        scrollWheelZoom: true
                    }).setView([lat, lng], 12);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(this.map);

                    this.marker = L.marker([lat, lng], { draggable: true }).addTo(this.map);

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

                    this.map.on('click', (e) => {
                        this.marker.setLatLng(e.latlng);
                        this.selectedLat = e.latlng.lat.toFixed(7);
                        this.selectedLng = e.latlng.lng.toFixed(7);
                        this.reverseGeocode(e.latlng.lat, e.latlng.lng);
                    });

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
