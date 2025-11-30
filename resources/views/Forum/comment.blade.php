<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Comment</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Lightbox2 CSS & JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
</head>

<body class="bg-gray-100">

    @include('partials.navbar')

    <div class="container mx-auto p-6 max-w-2xl">
        <h1 class="text-2xl font-bold mb-4">Komentar untuk: {{ $question->title }}</h1>

        <!-- Box post yang dibalas -->
        <!-- Box post yang dibalas -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">

            <!-- Tags -->
            @if (!empty($question->tags))
                <div class="mb-4">
                    @foreach ($question->tags as $tag)
                        <span
                            class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full text-sm mr-2">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            <!-- Judul post -->
            <h2 class="text-2xl font-semibold mb-2">{{ $question->title }}</h2>

            <!-- User info -->
            @php
                $user = $question->user ?? null;
                $profile = $user?->profile ?? null;
            @endphp
            <div class="flex items-center mb-4">
                <img src="{{ $profile?->profile_picture ? asset('storage/' . $profile->profile_picture) : asset('default-avatar.png') }}"
                    alt="Profile" class="w-12 h-12 rounded-full mr-3">
                <div>
                    <p class="font-medium">{{ $user?->name ?? 'Guest' }}</p>
                    <p class="text-gray-500 text-sm">{{ $question->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <!-- Gambar post -->
            @if ($question->image)
                <div class="mb-4">
                    <a href="{{ asset('storage/' . $question->image) }}" data-lightbox="post-{{ $question->_id }}">
                        <img src="{{ asset('storage/' . $question->image) }}" alt="Gambar pertanyaan"
                            class="rounded w-full max-h-96 object-cover cursor-pointer">
                    </a>
                </div>
            @endif

            <!-- Body post -->
            <p class="mb-4">{{ $question->body }}</p>

            <!-- Like + komentar info -->
            @php
                $liked = $question->likes()->where('user_id', Auth::id())->exists();
            @endphp
            <div class="flex items-center mb-2">
                <!-- Like button -->
                <form action="{{ route('questions.like', $question->_id) }}" method="POST" class="inline-block mr-4">
                    @csrf
                    <button type="submit" class="focus:outline-none">
                        @if ($liked)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3
                                 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3
                                 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 0 1 6.364 0L12 7.636l1.318-1.318
                                 a4.5 4.5 0 0 1 6.364 6.364L12 21.364 4.318 12.682a4.5 4.5 0 0 1 0-6.364z" />
                            </svg>
                        @endif
                    </button>
                </form>
                <span class="text-gray-700 mr-4">{{ $question->likes()->count() }}</span>

                <!-- Total komentar -->
                <div class="flex items-center text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8-1.113 0-2.18-.183-3.188-.525L3 21l1.525-5.813C3.183 14.18 3 13.113 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>{{ $question->comments->count() }}</span>
                </div>
            </div>

        </div>


        <!-- Form komentar baru -->
        @auth
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <form action="{{ route('comments.store', $question->_id) }}" method="POST">
                    @csrf
                    <textarea name="body" placeholder="Tulis komentar..." class="w-full border rounded p-2 mb-4" rows="4" required></textarea>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kirim
                        Komentar</button>
                    <a href="{{ route('forum.index') }}" class="ml-4 text-gray-700 hover:underline">Batal</a>
                </form>
            </div>
        @endauth

        <!-- Komentar user lain -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="font-semibold mb-4">Komentar lainnya:</h3>
            @forelse ($question->comments as $c)
                @php
                    $cProfile = $c->user->profile ?? null;
                @endphp
                <div class="flex items-start mb-4">
                    <img src="{{ $cProfile?->profile_picture ? asset('storage/' . $cProfile->profile_picture) : asset('default-avatar.png') }}"
                        alt="Profile" class="w-10 h-10 rounded-full mr-3 mt-1">
                    <div class="bg-gray-50 p-3 rounded-md w-full">
                        <p class="font-medium">{{ $c->user->name ?? 'Guest' }}
                            <span class="text-gray-500 text-sm ml-2">{{ $c->created_at->format('d M Y H:i') }}</span>
                        </p>
                        <p class="mt-1">{{ $c->body }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Belum ada komentar.</p>
            @endforelse
        </div>

    </div>

</body>

</html>
