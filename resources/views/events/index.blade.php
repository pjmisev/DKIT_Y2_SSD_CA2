<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Events</h2>
            @if (Auth::user()->isAdmin())
                <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Event
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Event {{ session('status') === 'event-created' ? 'created' : (session('status') === 'event-updated' ? 'updated' : 'deleted') }} successfully.
                </div>
            @endif

            @if ($events->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">No events scheduled.</p>
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('events.create') }}" class="mt-4 inline-block text-orange-500 hover:text-orange-600 text-sm font-semibold">Schedule the first event &rarr;</a>
                    @endif
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($events as $event)
                        @php $isPast = $event->end_time->isPast(); @endphp
                        <a href="{{ route('events.show', $event) }}" class="flex items-start gap-5 bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-5 hover:border-orange-200 hover:shadow-md transition-all duration-150 {{ $isPast ? 'opacity-60' : '' }}">
                            <div class="text-center w-14 shrink-0 bg-orange-50 rounded-xl py-2">
                                <div class="text-xs font-bold text-orange-500 uppercase">{{ $event->start_time->format('M') }}</div>
                                <div class="text-3xl font-black text-gray-800 leading-none">{{ $event->start_time->format('d') }}</div>
                                <div class="text-xs text-gray-400">{{ $event->start_time->format('Y') }}</div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-base font-semibold text-gray-900">{{ $event->name }}</span>
                                    @if ($isPast)
                                        <span class="text-xs bg-gray-100 text-gray-500 font-medium px-2 py-0.5 rounded-full">Past</span>
                                    @else
                                        <span class="text-xs bg-orange-100 text-orange-600 font-medium px-2 py-0.5 rounded-full">Upcoming</span>
                                    @endif
                                </div>
                                <div class="mt-1 text-sm text-gray-400 flex items-center gap-3 flex-wrap">
                                    <span>{{ $event->start_time->format('g:i A') }} – {{ $event->end_time->format('g:i A') }}</span>
                                    @if ($event->location)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $event->location }}
                                        </span>
                                    @endif
                                </div>
                                @if ($event->description)
                                    <p class="mt-1.5 text-sm text-gray-500 line-clamp-1">{{ $event->description }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
