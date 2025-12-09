<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    @include('partials.navbar')
    @include('partials.bubble')

    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">Leaderboard</h1>

        <div class="divide-y divide-gray-200">
            @forelse ($leaders as $index => $leader)
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-4">
                        <!-- Rank -->
                        <span class="text-lg font-bold w-6 text-center">{{ $leader->rank }}</span>

                        <!-- Avatar -->
                        @php
                            $profile = $leader->user->profile ?? null;
                            $initials = $leader->user->name
                                ? collect(explode(' ', $leader->user->name))
                                    ->map(fn($n) => strtoupper(substr($n, 0, 1)))
                                    ->take(2)
                                    ->join('')
                                : '';
                            $bgColor = 'bg-blue-500';
                        @endphp

                        <div class="h-12 w-12 rounded-full border flex items-center justify-center">
                            @if ($profile && $profile->profile_picture)
                                <img src="{{ asset('storage/' . $profile->profile_picture) }}" alt="Profile Picture"
                                    class="h-12 w-12 rounded-full object-cover">
                            @else
                                <div
                                    class="h-12 w-12 rounded-full flex items-center justify-center {{ $bgColor }}">
                                    <span class="text-sm font-bold text-white">{{ $initials }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Name + Badge -->
                        <div class="flex items-center gap-2">
                            <span class="text-gray-800 font-semibold">{{ $leader->user->name }}</span>
                            @if ($leader->badge)
                                <span
                                    class="px-2 py-1 text-sm rounded bg-yellow-100 text-yellow-800">{{ $leader->badge }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Weekly XP -->
                    <span class="text-gray-600 font-medium">{{ $leader->weekly_xp }} XP</span>
                </div>
            @empty
                <p class="text-center text-gray-500">No leaderboard data yet.</p>
            @endforelse
        </div>


    </div>

</body>

</html>
