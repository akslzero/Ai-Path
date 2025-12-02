<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AIPATH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    @include('partials.navbar')
    @include('partials.bubble')

    <div class="max-w-6xl mx-auto mt-10 p-6">
        <h1 class="text-3xl font-bold text-gray-800">Selamat datang, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600 mt-2">Mau belajar apa hari ini?</p>

        <div class="bg-white shadow-lg rounded-2xl p-6 mt-6">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Dashboard Overview</h2>

            <div class="flex flex-wrap gap-6">
                <div class="flex-1 min-w-[250px] max-w-[300px] bg-gray-50 rounded-xl p-5 shadow-sm">
                    <h3 class="text-lg font-medium text-gray-700">Courses in Progress</h3>
                    <p class="mt-3 text-3xl font-bold text-indigo-600">{{ $inProgress }}</p>
                </div>

                @if ($userCourses->count() > 0)
                    <div class="flex-1 min-w-[250px] max-w-[600px] bg-white rounded-2xl p-5 shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700 mb-4">Continue Courses</h3>
                        <div class="flex gap-4 overflow-x-auto w-full">
                            <div class="flex gap-4 w-max">
                                @foreach ($userCourses as $uc)
                                    <a href="{{ route('modules.index', $uc->course->id) }}">
                                        <div
                                            class="bg-gray-50 rounded-xl p-4 shadow-sm hover:bg-gray-100 transition min-w-[200px]">
                                            <h4 class="font-semibold text-gray-800">{{ $uc->course->title }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">Progress: {{ $uc->progress_percent }}%
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex-1 min-w-[250px] max-w-[300px] bg-gray-50 rounded-xl p-5 shadow-sm">
                    <h3 class="text-lg font-medium text-gray-700">Completed Courses</h3>
                    <p class="mt-3 text-3xl font-bold text-green-600">{{ $completed }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-2xl p-6 mt-10">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Daily XP</h2>
            <canvas id="xpChart"></canvas>
        </div>

        <div class="bg-white shadow-lg rounded-2xl p-6 mt-10">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Completed Modules per Day</h2>
            <canvas id="moduleChart"></canvas>
        </div>

    </div>

    <script>
        const ctx = document.getElementById('xpChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($xpDays['labels']),
                datasets: [{
                    label: 'XP Harian',
                    data: @json($xpDays['values']),
                    backgroundColor: 'rgba(255, 206, 86, 0.7)', // kuning
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 2,
                }]
            },
        });


        const moduleCtx = document.getElementById('moduleChart').getContext('2d');
        new Chart(moduleCtx, {
            type: 'line',
            data: {
                labels: @json($moduleLabels),
                datasets: [{
                    label: 'Modul Completed',
                    data: @json($moduleValues),
                    borderColor: 'rgba(255, 99, 132, 1)', // merah
                    backgroundColor: 'rgba(255, 99, 132, 0.3)', // merah transparan
                    borderWidth: 2,
                    tension: 0.3, // biar garis agak smooth
                }]
            }
        });
    </script>

</body>

</html>
