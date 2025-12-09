<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>setting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    @include('partials.navbar')

    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">

        <h1 class="text-2xl font-bold mb-6">setting</h1>

        <!-- Success Messages -->
        @if (session('success_profile'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success_profile') }}</div>
        @endif
        @if (session('success_password'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success_password') }}</div>
        @endif
        @if (session('success_picture'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success_picture') }}</div>
        @endif

        <!-- Update Name & Email -->
        <form action="{{ route('setting.updateProfile') }}" method="POST" class="mb-6">
            @csrf
            <h2 class="text-lg font-semibold mb-2">Profile Info</h2>
            <div class="mb-2">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="{{ $user->name }}"
                    class="w-full border px-3 py-2 rounded">
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ $user->email }}"
                    class="w-full border px-3 py-2 rounded">
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update
                Profile</button>
        </form>

        <!-- Update Password -->
        <form action="{{ route('setting.updatePassword') }}" method="POST" class="mb-6">
            @csrf
            <h2 class="text-lg font-semibold mb-2">Change Password</h2>
            <div class="mb-2">
                <label class="block text-gray-700">Current Password</label>
                <input type="password" name="current_password" class="w-full border px-3 py-2 rounded">
                @error('current_password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label class="block text-gray-700">New Password</label>
                <input type="password" name="new_password" class="w-full border px-3 py-2 rounded">
            </div>
            <div class="mb-2">
                <label class="block text-gray-700">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" class="w-full border px-3 py-2 rounded">
                @error('new_password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update
                Password</button>
        </form>

        <!-- Upload Profile Picture -->
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

            $hash = crc32($user->name);
            $bgColor = $colors[$hash % count($colors)];

            // inisial user
            $initials = collect(explode(' ', $user->name))
                ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                ->join(' ');
        @endphp


        <form action="{{ route('setting.uploadPicture') }}" method="POST" enctype="multipart/form-data"
            class="mb-6">
            @csrf
            <h2 class="text-lg font-semibold mb-2">Profile Picture</h2>

            <div class="flex items-center mb-2">

                {{-- Preview image / initial avatar --}}
                @if ($profile && $profile->profile_picture)
                    <img id="profilePreview" src="{{ asset('storage/' . $profile->profile_picture) }}"
                        class="h-16 w-16 rounded-full object-cover border mr-4">
                @else
                    <div id="profilePreviewFallback"
                        class="h-16 w-16 rounded-full border mr-4 flex items-center justify-center {{ $bgColor }}">
                        <span class="text-lg font-bold text-white">{{ $initials }}</span>
                    </div>
                @endif

                <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(event)">
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Upload Picture
            </button>

            @error('profile_picture')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </form>


        <!-- Delete Account -->
        <form action="{{ route('setting.deleteAccount') }}" method="POST"
            onsubmit="return confirm('Are you sure you want to delete your account?');" class="mb-6">
            @csrf
            <h2 class="text-lg font-semibold mb-2 text-red-600">Delete Account</h2>
            <div class="mb-2">
                <label class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password" class="w-full border px-3 py-2 rounded">
                @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete
                Account</button>
        </form>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Logout</button>
        </form>

    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('profilePreview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>

</html>
