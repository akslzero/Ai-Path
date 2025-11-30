<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    @include('partials.navbar')
    @include('partials.bubble')

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">My Courses</h1>

        @if (session('success'))
            <div class="p-3 mb-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($courses->isEmpty())
            <div class="p-4 bg-yellow-100 text-yellow-800 rounded">
                Belum ada course tersedia.
            </div>
        @else
            @php
                // Pisahkan course yang sudah terdaftar dan belum
                $enrolledCourses = $courses->filter(fn($c) => isset($progress[$c->id]));
                $notEnrolledCourses = $courses->reject(fn($c) => isset($progress[$c->id]));
            @endphp

            {{-- === Course yang sudah diambil === --}}
            @if ($enrolledCourses->isNotEmpty())
                <h2 class="text-xl font-semibold mb-3 text-blue-700">Sudah Diambil</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    @foreach ($enrolledCourses as $course)
                        <div class="p-4 border rounded shadow hover:shadow-lg transition bg-white">
                            <h2 class="text-xl font-semibold mb-2">{{ $course->title }}</h2>
                            <p class="text-gray-600 mb-2">{{ $course->description }}</p>

                            <p class="text-gray-700 mb-3">Progress: {{ $progress[$course->id] ?? 0 }}%</p>

                            <div class="flex gap-2">
                                <a href="{{ route('modules.index', $course->id) }}"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    Lihat Modules
                                </a>
                                <button class="px-3 py-1 bg-gray-400 text-white rounded cursor-not-allowed" disabled>
                                    Terdaftar
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- === Course yang belum diambil === --}}
            @if ($notEnrolledCourses->isNotEmpty())
                <h2 class="text-xl font-semibold mb-3 text-green-700">Belum Diambil</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($notEnrolledCourses as $course)
                        <div class="p-4 border rounded shadow hover:shadow-lg transition bg-white">
                            <h2 class="text-xl font-semibold mb-2">{{ $course->title }}</h2>
                            <p class="text-gray-600 mb-2">{{ $course->description }}</p>

                            <form action="{{ route('enroll-course', $course) }}" method="POST">
                                @csrf
                                <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                    Daftar Course
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>

</body>

</html>
