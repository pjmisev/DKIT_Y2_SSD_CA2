<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basketball Club Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    @php
        $upcomingEvents = \App\Models\Event::where('start_time', '>=', now())
            ->orderBy('start_time')
            ->take(4)
            ->get();

        $playerCount = class_exists(\App\Models\Player::class) ? \App\Models\Player::count() : 0;
        $coachCount = class_exists(\App\Models\Coach::class) ? \App\Models\Coach::count() : 0;
        $eventCount = \App\Models\Event::count();
        $nextEvent = $upcomingEvents->first();
    @endphp

    <div class="min-h-screen">
        <header style="background-color: #ea580c;" class="text-white shadow-md">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold leading-tight">Hoops Club</h1>
                    <p class="text-xs text-orange-100">Basketball Manager</p>
                </div>

                <nav class="flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('players.index') }}" class="hover:text-orange-200">Players</a>
                    <a href="{{ route('coaches.index') }}" class="hover:text-orange-200">Coaches</a>
                    <a href="{{ route('events.index') }}" class="hover:text-orange-200">Events</a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="hover:text-orange-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-orange-200">Login</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="max-w-6xl mx-auto px-6 py-10">
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-200">
                <div class="p-8">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5">
                            <p class="text-sm text-gray-500">Players</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $playerCount }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5">
                            <p class="text-sm text-gray-500">Coaches</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $coachCount }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5">
                            <p class="text-sm text-gray-500">Games</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $eventCount }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5">
                            <p class="text-sm text-gray-500">Next Event</p>
                            <p class="mt-2 text-lg font-bold text-gray-900">
                                {{ $nextEvent ? $nextEvent->start_time->format('d M') : 'TBC' }}
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-6 mt-8">
                        <div class="bg-white rounded-2xl border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-bold text-gray-900">Upcoming Games</h2>
                                <a href="{{ route('events.index') }}" class="text-sm font-medium text-orange-600 hover:text-orange-700">
                                    View all
                                </a>
                            </div>

                            @if ($upcomingEvents->isEmpty())
                                <div class="rounded-xl bg-gray-50 border border-gray-200 p-4 text-gray-500">
                                    No upcoming events yet.
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach ($upcomingEvents as $event)
                                        <a href="{{ route('events.show', $event) }}"
                                           class="block rounded-xl bg-gray-50 border border-gray-200 p-4 hover:bg-orange-50 hover:border-orange-200 transition">
                                            <div class="flex items-start gap-4">
                                                <div class="w-1 self-stretch rounded-full bg-orange-500"></div>

                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $event->name }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 mt-1">
                                                        {{ $event->start_time->format('D, d M') }}
                                                        · {{ $event->start_time->format('g:i A') }}
                                                    </p>
                                                    @if ($event->location)
                                                        <p class="text-sm text-gray-500 mt-1">
                                                            {{ $event->location }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>