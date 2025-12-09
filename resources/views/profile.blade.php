<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Navbar tetap di atas -->
    @include('partials.navbar')

    <!-- Bubble partial -->
    @include('partials.bubble')

    <!-- Konten utama di-center -->
    <div class="flex items-center justify-center mt-10">
        <div class="max-w-md w-full bg-white shadow-md rounded-lg p-6">

            <!-- Foto Profil (read-only) -->
            @php
                // daftar warna background biar tetap aesthetic
                $colors = [
                    'bg-red-400',
                    'bg-blue-400',
                    'bg-green-400',
                    'bg-yellow-400',
                    'bg-purple-400',
                    'bg-pink-400',
                    'bg-indigo-400',
                    'bg-teal-400',
                ];

                // ambil user ID atau name sebagai sumber hash
                $hash = crc32($user->name);

                // pilih warna berdasarkan hash (biar konsisten)
                $bgColor = $colors[$hash % count($colors)];

                // ambil inisial
                $initials = collect(explode(' ', $user->name))
                    ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                    ->join(' ');
            @endphp


            <div class="flex justify-center mb-4">
                @if ($profile && $profile->profile_picture)
                    <img src="{{ asset('storage/' . $profile->profile_picture) }}" alt="Profile Picture"
                        class="h-24 w-24 rounded-full object-cover border-2 border-blue-500">
                @else
                    <div
                        class="h-24 w-24 rounded-full border-2 border-blue-500 flex items-center justify-center {{ $bgColor }}">
                        <span class="text-2xl font-bold text-white">{{ $initials }}</span>
                    </div>
                @endif
            </div>


            <!-- Nama & Role -->
            <h2 class="text-center text-2xl font-bold mb-1">{{ $user->name }}</h2>
            <p class="text-center text-gray-500 mb-1 capitalize">{{ $profile->role ?? 'member' }}</p>


            <!-- Stats -->
            <div class="flex justify-around text-center mb-4">
                <div>
                    <p class="text-lg font-semibold">{{ $profile->level ?? 1 }}</p>
                    <p class="text-gray-500 text-sm">Level</p>
                </div>
                <div>
                    <p class="text-lg font-semibold">{{ $profile->total_xp ?? 0 }}</p>
                    <p class="text-gray-500 text-sm">Total XP</p>
                </div>

            </div>

            <div class="flex justify-around text-center mb-4">
                @if ($user->leaderboard)
                    <p>Rank: {{ $user->leaderboard->rank }}</p>
                    @if ($user->leaderboard->badge)
                        <p>Badge: <span>{{ $user->leaderboard->badge }}</span></p>
                    @endif
                @else
                    <p class="text-sm text-gray-400">Belum ada data leaderboard.</p>
                @endif
            </div>


            <p class="text-center text-gray-400 text-sm">
                Member since {{ $user->created_at->format('F j, Y') }}
            </p>

            <!-- Bio -->
            @if ($profile && $profile->bio)
                <div class="mt-4 p-3 bg-gray-100 rounded">
                    <p class="text-gray-700 text-sm">{{ $profile->bio }}</p>
                </div>
            @endif

        </div>
    </div>

</body>

</html>
