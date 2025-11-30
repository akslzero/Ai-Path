<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modules - {{ $course->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

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
        <div class="bg-white p-6 rounded-lg shadow mb-6">
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

                        // default tidak dikunci
                        $isLocked = false;

                        // kalau ini bukan modul pertama, cek modul sebelumnya
                        if ($index > 0) {
                            $prevModule = $modules[$index - 1];
                            $prevProgress = $prevModule->userProgress->first();
                            $isLocked = !$prevProgress || $prevProgress->status !== 'completed';
                        }

                        $icon =
                            $status === 'completed'
                                ? '✅'
                                : ($status === 'in_progress'
                                    ? '▶️'
                                    : ($isLocked
                                        ? '🔒'
                                        : '🟢'));
                    @endphp

                    <div
                        class="p-4 bg-white border rounded shadow flex justify-between items-center hover:shadow-md transition">
                        <div>
                            <h2 class="text-xl font-semibold text-blue-700 flex items-center gap-2">
                                <span>{{ $icon }}</span> {{ $module->title }}
                            </h2>
                            <p class="text-gray-700 mt-1">{{ $module->content }}</p>
                        </div>

                        @if (!$isLocked)
                            @php
                                // Cari lesson pertama pada modul yang punya soal
                                $firstLessonWithQuestion = $module->lessons
                                    ? $module->lessons->first(function ($lesson) {
                                        return $lesson->questions && $lesson->questions->count() > 0;
                                    })
                                    : null;
                            @endphp
                            @if ($firstLessonWithQuestion)
                                <a href="{{ route('lessons.show', $firstLessonWithQuestion->id) }}"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Buka</a>
                            @else
                                <a href="{{ route('module.show', $module) }}"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Buka</a>
                            @endif
                        @else
                            <button class="px-3 py-1 bg-gray-400 text-white rounded cursor-not-allowed"
                                disabled>Terkunci</button>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('mycourses') }}"
                class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                ← Kembali ke My Courses
            </a>
        </div>
    </div>

</body>

</html>
