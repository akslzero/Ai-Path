<!-- resources/views/partials/navbar.blade.php -->
<nav class="bg-[#e9f9ff] px-6 py-3 shadow flex items-center justify-between relative" x-data="{ mobileOpen: false }">

    <!-- Logo -->
    <div class="flex items-center gap-2">
        <img src="{{ asset('images/logo.png') }}" alt="AIPATH" class="h-8 w-8">
        <h1 class="text-2xl font-bold text-blue-700">AIPath</h1>
    </div>

    <!-- Search Bar (Desktop) -->
    <div class="hidden md:flex mx-6 flex-1 max-w-xl">
        <div class="relative w-full">
            <input type="text" placeholder="Ready To Learn?"
                class="w-full rounded-full border border-gray-300 pl-10 pr-4 py-2 text-sm shadow-sm bg-white/70 backdrop-blur focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
        </div>
    </div>

    <!-- Burger Menu Mobile -->
    <div class="md:hidden">
        <button @click="mobileOpen = !mobileOpen" class="text-gray-700 focus:outline-none">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </div>

    <!-- Menu + Icons + Profile (Desktop) -->
    <ul class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-700">
        <li><a href="{{ route('dashboard') }}"
                class="hover:text-blue-900 {{ request()->routeIs('dashboard') ? 'text-blue-700 font-semibold' : '' }}">Dashboard</a>
        </li>
        <li><a href="{{ route('forum.index') }}"
                class="hover:text-blue-900 {{ request()->routeIs('forum.index') ? 'text-blue-700 font-semibold' : '' }}">Discuss</a>
        </li>
        <li><a href="{{ route('leaderboard') }}"
                class="hover:text-blue-900 {{ request()->routeIs('leaderboard') ? 'text-blue-700 font-semibold' : '' }}">Leaderboard</a>
        </li>
        <li><a href="{{ route('join') }}"
                class="hover:text-blue-900 {{ request()->routeIs('join') ? 'text-blue-700 font-semibold' : '' }}">Join
                Us</a></li>
        <li><a href="{{ route('mycourses') }}"
                class="hover:text-blue-900 {{ request()->routeIs('mycourses') ? 'text-blue-700 font-semibold' : '' }}">My
                Courses</a></li>
        <li>
            <a href="{{ route('certificate') }}"
                class="hover:text-blue-900 {{ request()->routeIs('certificate') ? 'text-blue-700 font-semibold' : '' }}">
                Certificate
            </a>
        </li>

        <li><a href="#" class="relative hover:text-blue-900"><i class="fas fa-bell text-lg"></i></a></li>
        <li><a href="#" class="relative hover:text-blue-900"><i class="fas fa-envelope text-lg"></i></a></li>

        <li x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="h-9 w-9 rounded-full overflow-hidden hover:ring-2 hover:ring-blue-300 transition">

                @php
                    $user = Auth::user();
                    $profile = $user?->profile;

                    // daftar warna
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

                    $name = $user?->name ?? 'Guest';
                    $hash = crc32($name);
                    $bgColor = $colors[$hash % count($colors)];

                    // inisial nama
                    $initials = collect(explode(' ', $name))
                        ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                        ->join(' ');
                @endphp

                @if ($profile?->profile_picture)
                    <img src="{{ asset('storage/' . $profile->profile_picture) }}" alt="Profile"
                        class="h-full w-full object-cover">
                @else
                    <div class="h-full w-full flex items-center justify-center {{ $bgColor }}">
                        <span class="text-sm font-bold text-white">{{ $initials }}</span>
                    </div>
                @endif
            </button>


            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0 mt-3 w-48 bg-white shadow-lg rounded-lg z-50 overflow-hidden">
                <a href="{{ route('profile') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Profile</a>
                <a href="{{ route('setting') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">User
                    Settings</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Help</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 hover:text-red-600">Logout</button>
                </form>
            </div>
        </li>
    </ul>

    <!-- Mobile Menu -->
    <div x-show="mobileOpen" @click.outside="mobileOpen = false"
        class="md:hidden absolute top-full left-0 w-full bg-[#e9f9ff] shadow-lg z-40">
        <ul class="flex flex-col gap-3 p-4 text-gray-700">
            <li><a href="{{ route('dashboard') }}"
                    class="hover:text-blue-900 {{ request()->routeIs('dashboard') ? 'text-blue-700 font-semibold' : '' }}">Dashboard</a>
            </li>
            <li><a href="{{ route('forum.index') }}"
                    class="hover:text-blue-900 {{ request()->routeIs('forum.index') ? 'text-blue-700 font-semibold' : '' }}">Discuss</a>
            </li>
            <li><a href="{{ route('leaderboard') }}"
                    class="hover:text-blue-900 {{ request()->routeIs('leaderboard') ? 'text-blue-700 font-semibold' : '' }}">Leaderboard</a>
            </li>
            <li><a href="{{ route('join') }}"
                    class="hover:text-blue-900 {{ request()->routeIs('join') ? 'text-blue-700 font-semibold' : '' }}">Join
                    Us</a></li>
            <li><a href="{{ route('mycourses') }}"
                    class="hover:text-blue-900 {{ request()->routeIs('mycourses') ? 'text-blue-700 font-semibold' : '' }}">My
                    Courses</a></li>
            <li>
                <a href="{{ route('certificate') }}"
                    class="hover:text-blue-900 {{ request()->routeIs('certificate') ? 'text-blue-700 font-semibold' : '' }}">
                    Certificate
                </a>
            </li>
            <li><a href="#" class="hover:text-blue-900">Notifications</a></li>
            <li><a href="#" class="hover:text-blue-900">Messages</a></li>
            <li><a href="{{ route('profile') }}" class="hover:text-blue-900">Profile</a></li>
            <li><a href="{{ route('setting') }}" class="hover:text-blue-900">User Settings</a></li>
            <li><a href="#" class="hover:text-blue-900">Help</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-red-700 hover:bg-red-50 hover:text-red-600">Logout</button>
                </form>
            </li>
        </ul>
    </div>

</nav>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
