<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AIPATH</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#f0f8ff] font-sans">

    <!-- Navbar -->
    <nav class="flex flex-wrap items-center justify-between bg-white px-6 md:px-8 py-4 shadow">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="AIPATH" class="h-8 w-8">
            <h1 class="text-2xl font-bold text-blue-700">AIPath</h1>
        </div>

        <div class="hidden md:block flex-1 mx-8">
            <input type="text" placeholder="Ready To Learn?"
                class="w-full max-w-lg rounded-full border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div class="flex gap-2 mt-2 md:mt-0">
            <a href="{{ route('login') }}"
                class="px-4 py-2 border border-blue-600 rounded-md text-blue-600 hover:bg-blue-50">LOGIN</a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">SIGN
                UP</a>
        </div>
    </nav>

    <!-- Login Section -->
    <div class="flex flex-col md:flex-row justify-center items-center min-h-[calc(100vh-80px)] px-6 md:px-12 py-10">
        <div class="flex bg-white rounded-2xl shadow-lg overflow-hidden max-w-6xl w-full">


            <!-- Left Section -->
            <div
                class="bg-gradient-to-b from-blue-600 to-blue-800 text-white flex flex-col justify-center p-8 md:p-10 md:w-1/2 w-full text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-bold mb-3">Welcome Back to AIPATH</h2>
                <p class="text-gray-200 text-sm md:text-base">Log in to continue your journey in the next generation of
                    intelligence.</p>
            </div>

            <!-- Right Section -->
            <div class="bg-blue-50 flex flex-col justify-center p-8 md:p-10 md:w-1/2 w-full">
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    <div>
                        <input type="email" name="email" placeholder="Your email address"
                            class="w-full rounded-md border border-gray-300 px-4 py-3 md:py-3.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                    </div>

                    <div>
                        <input type="password" name="password" placeholder="Password"
                            class="w-full rounded-md border border-gray-300 px-4 py-3 md:py-3.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                    </div>

                    <div class="flex flex-col md:flex-row items-center justify-between text-sm text-gray-600 gap-2">
                        <p>Don’t have an account?
                            <a href="{{ route('register') }}" class="text-blue-700 font-semibold">Sign Up</a>
                        </p>
                        <a href="#" class="text-blue-600 hover:underline">Forgot Password?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-700 text-white font-semibold py-3 md:py-3.5 rounded-md hover:bg-blue-800 transition">
                        LOGIN
                    </button>
                </form>
            </div>

        </div>
    </div>

</body>

</html>
