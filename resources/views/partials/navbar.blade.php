<!-- resources/views/partials/navbar.blade.php -->
<nav class="bg-[#e9f9ff] px-6 py-3 shadow flex items-center justify-between relative">

    <!-- Logo -->
    <div class="flex items-center gap-2">
        <img src="{{ asset('images/logo.png') }}" alt="AIPATH" class="h-8 w-8">
        <h1 class="text-2xl font-bold text-blue-700">AIPath</h1>
    </div>

    <!-- Search Bar -->
    <!-- Search Bar -->
    <div class="hidden md:flex mx-6 flex-1 max-w-xl">
        <div class="relative w-full">
            <input type="text" placeholder="Ready To Learn?"
                class="w-full rounded-full border border-gray-300 pl-10 pr-4 py-2 text-sm
                   shadow-sm bg-white/70 backdrop-blur 
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
        </div>
    </div>




    <!-- Menu + Icons + Profile -->
    <ul class="flex items-center gap-6 text-sm font-medium text-gray-700">

        <!-- Normal Menu -->
        <li>
            <a href="{{ route('dashboard') }}"
                class="hover:text-blue-900 {{ request()->routeIs('dashboard') ? 'text-blue-700 font-semibold' : '' }}">
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('forum.index') }}"
                class="hover:text-blue-900 {{ request()->routeIs('forum.index') ? 'text-blue-700 font-semibold' : '' }}">
                Discuss
            </a>
        </li>

        <li>
            <a href="{{ route('leaderboard') }}"
                class="hover:text-blue-900 {{ request()->routeIs('leaderboard') ? 'text-blue-700 font-semibold' : '' }}">
                Leaderboard
            </a>
        </li>

        <li>
            <a href="{{ route('join') }}"
                class="hover:text-blue-900 {{ request()->routeIs('join') ? 'text-blue-700 font-semibold' : '' }}">
                Join Us
            </a>
        </li>

        <li>
            <a href="{{ route('mycourses') }}"
                class="hover:text-blue-900 {{ request()->routeIs('mycourses') ? 'text-blue-700 font-semibold' : '' }}">
                My Courses
            </a>
        </li>

        <li>
            <a href="{{ route('certificate') }}"
                class="hover:text-blue-900 {{ request()->routeIs('certificate') ? 'text-blue-700 font-semibold' : '' }}">
                Certificate
            </a>
        </li>

        <!-- 🔔 Notifikasi -->
        <li>
            <a href="#" class="relative hover:text-blue-900">
                <i class="fas fa-bell text-lg"></i>
            </a>
        </li>

        <!-- 📩 Email -->
        <li>
            <a href="#" class="relative hover:text-blue-900">
                <i class="fas fa-envelope text-lg"></i>
            </a>
        </li>

        <!-- Profile Dropdown -->
        <li x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="h-9 w-9 rounded-full overflow-hidden hover:ring-2 hover:ring-blue-300 transition">
                @php
                    $profile = Auth::user()?->profile;
                    $profilePicture = $profile?->profile_picture
                        ? asset('storage/' . $profile->profile_picture)
                        : asset('images/default-avatar.png');
                @endphp

                <img src="{{ $profilePicture }}" alt="Profile" class="h-full w-full object-cover">
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0 mt-3 w-48 bg-white shadow-lg rounded-lg border z-50 overflow-hidden">

                <a href="{{ route('profile') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Profile</a>

                <a href="{{ route('setting') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">User
                    Settings</a>

                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Help</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
