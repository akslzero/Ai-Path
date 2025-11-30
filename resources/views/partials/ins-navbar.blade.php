<!-- resources/views/partials/navbar.blade.php -->
<nav class="bg-[#e9f9ff] flex items-center justify-between px-8 py-3 shadow relative">

    <!-- Logo -->
    <div class="flex items-center gap-2">
        <img src="{{ asset('images/logo.png') }}" alt="AIPATH" class="h-8 w-8 object-contain">
        {{-- <h1 class="text-2xl font-bold text-blue-700">AIPath</h1> --}}
    </div>


    <!-- Menu -->
    <ul class="flex items-center gap-6 text-sm font-medium text-gray-700">
        <li>
            <a href="{{ route('instructor.dashboard') }}"
                class="hover:text-blue-900 {{ request()->routeIs('instructor.dashboard') ? 'text-blue-700 font-semibold' : 'text-gray-700' }}">
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('instructor.manage') }}"
                class="hover:text-blue-900 {{ request()->routeIs('instructor.manage') ? 'text-blue-700 font-semibold' : 'text-gray-700' }}">
                Manage Courses
            </a>
        </li>

        <!-- Profile Dropdown -->
        <li x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="h-9 w-9 rounded-full overflow-hidden flex items-center justify-center hover:bg-gray-200 transition">
                @php
                    $profile = Auth::user()?->profile ?? null;
                    $profilePicture =
                        $profile && $profile->profile_picture
                            ? asset('storage/' . $profile->profile_picture)
                            : asset('images/default-avatar.png'); // fallback default
                @endphp
                <img src="{{ $profilePicture }}" alt="Profile" class="h-full w-full object-cover">
            </button>


            <!-- Dropdown Box -->
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0 mt-3 w-48 bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200 z-50">

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
