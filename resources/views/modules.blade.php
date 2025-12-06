<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modules - {{ $course->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-blue-500">

    @include('partials.navbar')
    @include('partials.bubble')

    {{-- Secondary Navbar: Enrolled Courses --}}
    @if (isset($enrolledCourses) && $enrolledCourses->isNotEmpty())
        <div class="w-full bg-white shadow border-b sticky top-0 z-40">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center gap-6 justify-center overflow-x-auto no-scrollbar">

                    @foreach ($enrolledCourses as $c)
                        <a href="{{ route('modules.index', $c->id) }}"
                            class="text-sm font-medium whitespace-nowrap px-3 py-1 transition 
                            {{ $c->id == $course->id ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                            {{ $c->title }}
                        </a>
                    @endforeach

                </div>
            </div>
        </div>
    @endif


    <div class="container mx-auto px-4 py-6">
        <!-- Box Info Kursus -->
        <div class="bg-white p-6 rounded-lg shadow mb-6 flex items-start gap-4">

            <!-- ICON -->
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center overflow-hidden">
                @if ($course->icon)
                    <img src="{{ asset('storage/' . $course->icon) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-blue-600 text-3xl">📘</span>
                @endif
            </div>

            <!-- TEXT AREA -->
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-blue-700 mb-2">{{ $course->title }}</h1>
                <p class="text-gray-700 mb-4">{{ $course->description }}</p>

                <div class="mb-2 flex justify-between text-sm text-gray-600">
                    <span>Progress</span>
                    <span>{{ $progress->progress_percent ?? 0 }}%</span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                    <div class="bg-green-500 h-4 rounded-full transition-all duration-500"
                        style="width: {{ $progress->progress_percent ?? 0 }}%">
                    </div>
                </div>
            </div>
        </div>


        <!-- Notifikasi -->
        @if (session('success'))
            <div class="p-3 mb-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Daftar modul -->
        @if ($modules->isEmpty())
            <div class="p-4 bg-yellow-100 text-yellow-800 rounded">
                Belum ada modul tersedia.
            </div>
        @else
            <div class="space-y-4">
                @foreach ($modules as $index => $module)
                    @php
                        $userProgress = $module->userProgress->first();
                        $status = $userProgress->status ?? 'not_started';

                        $isLocked = false;

                        if ($index > 0) {
                            $prevModule = $modules[$index - 1];
                            $prevProgress = $prevModule->userProgress->first();
                            $isLocked = !$prevProgress || $prevProgress->status !== 'completed';
                        }

                        $isCompleted = $status === 'completed';
                        $isActive = !$isLocked && !$isCompleted;
                    @endphp

                    <div
                        class="
            relative rounded-lg p-4 shadow-sm transition
            @if ($isLocked) bg-gray-300 opacity-80 cursor-not-allowed
            @else
                bg-white hover:shadow-md @endif
        ">

                        <!-- Ikon status kanan atas -->
                        <div class="absolute top-3 right-3 text-xl">
                            @if ($isCompleted)
                                <i class="fa-regular fa-circle-check"></i>
                            @elseif ($isLocked)
                                <i class="fas fa-lock text-gray-700"></i>
                            @else
                                <i class="fas fa-circle-play text-gray-700"></i>
                            @endif
                        </div>

                        <!-- Layout konten utama -->
                        <div class="flex items-start gap-4">

                            <!-- Ikon Buku Kiri -->
                            <div class="text-4xl">
                                <i class="fas fa-file-lines text-gray-700"></i>
                            </div>

                            <!-- Info Kanan -->
                            <div>
                                <p class="text-sm text-gray-500">Lesson</p>

                                <h2 class="text-lg font-semibold text-gray-900">
                                    {{ $module->title }}
                                </h2>

                                <span class="inline-block text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded mt-1">
                                    XP +{{ $module->xp_reward }}
                                </span>

                            </div>
                        </div>

                        <!-- BUTTON -->
                        @if ($isActive)
                            @php
                                $firstLessonWithQuestion = $module->lessons
                                    ? $module->lessons->first(function ($lesson) {
                                        return $lesson->questions && $lesson->questions->count() > 0;
                                    })
                                    : null;
                            @endphp

                            <div class="mt-4">
                                <a href="{{ $firstLessonWithQuestion ? route('lessons.show', $firstLessonWithQuestion->id) : route('module.show', $module) }}"
                                    class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                                    Start Learn
                                </a>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>


        @endif

        <div class="mt-6">
            <a href="{{ route('mycourses') }}"
                class="inline-block px-4 py-2 bg-white text-black-600 rounded hover:bg-gray-100">
                Kembali ke My Courses
            </a>
        </div>
    </div>

</body>

</html>
