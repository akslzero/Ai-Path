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

    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">Leaderboard</h1>

        <div class="divide-y divide-gray-200">
            @forelse ($leaders as $index => $leader)
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-4">
                        <!-- Rank -->
                        <span class="text-lg font-bold w-6 text-center">{{ $index + 1 }}</span>

                        <!-- Avatar -->
                        <img src="{{ $leader->user->profile && $leader->user->profile->profile_picture ? asset('storage/' . $leader->user->profile->profile_picture) : asset('images/default-avatar.png') }}"
                            alt="Avatar" class="h-12 w-12 rounded-full object-cover border">

                        <!-- Name -->
                        <span class="text-gray-800 font-semibold">{{ $leader->user->name }}</span>
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
