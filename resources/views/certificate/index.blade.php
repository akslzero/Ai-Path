<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Bubble --}}
    @include('partials.bubble')

    <div class="max-w-4xl mx-auto mt-10 px-4">

        <h1 class="text-3xl font-bold mb-6 text-blue-700">Your Certificates</h1>

        @if($courses->isEmpty())
            <div class="p-6 bg-white shadow rounded text-center">
                <p class="text-gray-600">
                    Lu belum ngambil course apa pun bro 😁  
                    <span class="font-semibold">Kumpulin XP dulu baru bisa dapet sertifikat!</span>
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                @foreach($courses as $course)
                    @php
                        $percent = $progress[$course->id]->progress_percent ?? 0;
                        $completed = $percent >= 100;
                    @endphp

                    <div class="bg-white shadow rounded p-4 border">
                        <h2 class="text-xl font-semibold mb-2">{{ $course->title }}</h2>

                        <p class="text-gray-600 mb-2">
                            Progress:
                            <span class="{{ $completed ? 'text-green-600' : 'text-red-600' }}">
                                {{ $percent }}%
                            </span>
                        </p>

                        <div class="w-full bg-gray-200 rounded h-3 mb-4">
                            <div class="h-3 rounded bg-blue-600" style="width: {{ $percent }}%;"></div>
                        </div>

                        @if($completed)
                            <a href="{{ route('certificate.download', $course->id) }}"
                               class="block text-center bg-green-600 hover:bg-green-700 text-white py-2 rounded">
                                Download Certificate
                            </a>
                        @else
                            <button
                                class="block w-full text-center bg-gray-300 text-gray-700 py-2 rounded cursor-not-allowed">
                                Complete the course to unlock certificate
                            </button>
                        @endif

                    </div>

                @endforeach

            </div>
        @endif

    </div>

</body>
</html>
