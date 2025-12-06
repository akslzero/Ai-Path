<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Courses</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-blue-500 min-h-screen">
    @include('partials.navbar')
    @include('partials.bubble')

    <div class="container mx-auto px-4 py-10">
        <!-- Title -->
        <h1 class="text-3xl font-extrabold text-white text-center mb-8 tracking-wide">My Courses</h1>

        <!-- SUCCESS ALERT -->
        @if (session('success'))
            <div class="p-4 mb-6 bg-green-100 text-green-800 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        @if ($courses->isEmpty())
            <div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg shadow text-center">Belum ada course tersedia.</div>
        @else
            @php
                $enrolledCourses = $courses->filter(fn($c) => isset($progress[$c->id]));
                $notEnrolledCourses = $courses->reject(fn($c) => isset($progress[$c->id]));
            @endphp

            <!-- ENROLLED COURSES (SMALL BOXES) -->
            @if ($enrolledCourses->isNotEmpty())


                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                    @foreach ($enrolledCourses as $course)
                        <a href="{{ route('modules.index', $course->id) }}"
                            class="bg-white rounded-2xl shadow-lg p-5 border border-gray-200 flex flex-col items-center text-center 
                   hover:scale-[1.03] transition">

                            <!-- ICON -->
                            <div
                                class="bg-blue-100 p-4 rounded-full mb-3 flex items-center justify-center w-20 h-20 overflow-hidden">
                                @if ($course->icon)
                                    <img src="{{ asset('storage/' . $course->icon) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <span class="text-blue-600 text-3xl">📘</span>
                                @endif
                            </div>

                            <!-- TITLE -->
                            <h3 class="font-semibold text-lg mb-1">{{ $course->title }}</h3>

                            <!-- PROGRESS INLINE -->
                            <div class="flex items-center gap-1">
                                <span class="text-green-600 font-medium text-sm">Progress:</span>
                                <span class="text-gray-700 font-semibold text-sm">{{ $progress[$course->id] }}%</span>
                            </div>

                        </a>
                    @endforeach
                </div>




            @endif

            <!-- NOT ENROLLED COURSES -->
            @if ($notEnrolledCourses->isNotEmpty())
                <h2 class="text-2xl font-semibold text-white mb-4 text-center">AI Engineer Courses</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($notEnrolledCourses as $course)
                        <form action="{{ route('enroll-course', $course) }}" method="POST" class="cursor-pointer"
                            onclick="this.submit()">
                            @csrf

                            <div
                                class="bg-white flex items-start gap-5 rounded-2xl shadow-xl p-6 border border-gray-200 hover:scale-[1.02] transition-all">

                                <!-- ICON -->
                                <div
                                    class="bg-green-100 p-4 rounded-full flex items-center justify-center w-20 h-20 overflow-hidden">
                                    @if ($course->icon)
                                        <img src="{{ asset('storage/' . $course->icon) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <span class="text-green-600 text-3xl">📗</span>
                                    @endif
                                </div>


                                <!-- TEXT -->
                                <div class="flex-1 text-left">
                                    <h2 class="text-xl font-semibold mb-1">{{ $course->title }}</h2>
                                    <p class="text-gray-600 leading-relaxed text-sm">
                                        {{ $course->description }}
                                    </p>
                                </div>

                            </div>
                        </form>
                    @endforeach
                </div>

            @endif
        @endif
    </div>
</body>

</html>
