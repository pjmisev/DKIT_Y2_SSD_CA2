<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <p class="text-gray-500 mb-8">Welcome back, <span class="font-semibold text-gray-800">{{ Auth::user()->name }}</span>.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Players Card -->
                <a href="{{ route('players.index') }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-indigo-200 transition-all duration-200">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-800">{{ \App\Models\Player::count() }}</div>
                            <div class="text-sm text-gray-500">Players</div>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-indigo-600 group-hover:text-indigo-700">View roster &rarr;</span>
                </a>

                <!-- Events Card -->
                <a href="{{ route('events.index') }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-orange-200 transition-all duration-200">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-800">{{ \App\Models\Event::count() }}</div>
                            <div class="text-sm text-gray-500">Events</div>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-orange-600 group-hover:text-orange-700">View schedule &rarr;</span>
                </a>
            </div>

            <!-- Upcoming Events -->
            @php $upcoming = \App\Models\Event::where('start_time', '>=', now())->orderBy('start_time')->limit(3)->get(); @endphp
            @if ($upcoming->isNotEmpty())
                <div class="mt-10">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Upcoming Events</h3>
                    <div class="space-y-3">
                        @foreach ($upcoming as $event)
                            <a href="{{ route('events.show', $event) }}" class="flex items-center gap-4 bg-white rounded-xl border border-gray-100 px-5 py-4 hover:border-indigo-200 hover:shadow-sm transition-all duration-150">
                                <div class="text-center w-12 shrink-0">
                                    <div class="text-xs font-semibold text-indigo-500 uppercase">{{ $event->start_time->format('M') }}</div>
                                    <div class="text-2xl font-bold text-gray-800 leading-none">{{ $event->start_time->format('d') }}</div>
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-gray-800 truncate">{{ $event->name }}</div>
                                    <div class="text-sm text-gray-400">{{ $event->start_time->format('g:i A') }}@if($event->location) &middot; {{ $event->location }}@endif</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
