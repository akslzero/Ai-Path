<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Join With Us</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">

    @include('partials.navbar')
    @include('partials.bubble')


    <div class="max-w-xl mx-auto pt-10">
        <h1 class="text-center text-2xl font-bold mb-6">JOIN AS INSTRUCTOR!</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('join.store') }}" method="POST" class="bg-white p-6 shadow rounded">
            @csrf

            <label class="text-sm font-semibold">Username</label>
            <input type="text" name="username" class="w-full border rounded p-2 mb-3" placeholder="username"
                required>

            <label class="text-sm font-semibold">Full name</label>
            <input type="text" name="full_name" class="w-full border rounded p-2 mb-3" placeholder="full name"
                required>

            <label class="text-sm font-semibold">Email</label>
            <input type="email" name="email" class="w-full border rounded p-2 mb-3" placeholder="email" required>

            <label class="text-sm font-semibold">Message</label>
            <textarea name="message" class="w-full border rounded p-2 mb-4" rows="4" placeholder="type message"></textarea>

            <button class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Submit
            </button>
        </form>

        <div class="bg-white p-6 shadow rounded mt-8">
            <h2 class="text-xl font-bold mb-2">AIPath inc.</h2>
            <p class="mb-4 text-gray-600">Solo, Jawa Tengah</p>

            <p><strong>Facebook:</strong> <a class="text-blue-600" href="#">www.facebook.com/aipath</a></p>
            <p><strong>Instagram:</strong> <span class="text-blue-600">@aipath</span></p>
            <p><strong>Partnership & Support:</strong> <a class="text-blue-600"
                    href="mailto:info@aipath.com">info@aipath.com</a></p>
        </div>

    </div>

</body>

</html>
