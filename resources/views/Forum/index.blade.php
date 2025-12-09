<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    @include('partials.navbar')
    @include('partials.bubble')

    <div class="mx-auto max-w-full px-4 sm:px-6 lg:px-8 py-6">

        <h1 class="text-3xl font-bold mb-6 text-center sm:text-left">Q&A Discussion</h1>

        <!-- Search + Filter Tags -->
        <form action="{{ route('forum.index') }}" method="GET"
            class="mb-6 flex flex-col sm:flex-row gap-2 items-start sm:items-center" id="filterForm">
            <input type="text" name="q" value="{{ request('q') }}"
                placeholder="Cari pertanyaan, komentar, atau tag..."
                class="flex-1 border rounded px-4 py-2 w-full sm:w-auto focus:outline-none focus:ring focus:border-blue-300">
            <select name="tag"
                class="border rounded px-3 py-2 w-full sm:w-auto focus:outline-none focus:ring focus:border-blue-300"
                onchange="document.getElementById('filterForm').submit()">
                <option value="">-- Filter by Tag --</option>
                @foreach ($allTags as $tag)
                    <option value="{{ $tag }}" {{ $selectedTag == $tag ? 'selected' : '' }}>{{ $tag }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full sm:w-auto">
                Search
            </button>
        </form>

        @auth
            <div class="mb-6">
                <a href="{{ route('questions.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full sm:w-auto inline-block text-center">
                    Ask Question
                </a>
            </div>
        @endauth

        @foreach ($questions as $q)
            <div
                class="bg-white rounded-lg shadow-md p-6 mb-6 flex flex-col justify-between w-full max-w-full overflow-hidden">

                <!-- Konten pertanyaan -->
                <div>
                    <h2 class="text-2xl font-semibold mb-2">{{ $q->title }}</h2>

                    <!-- Tags -->
                    @if (!empty($q->tags))
                        <div class="mb-4 flex flex-wrap gap-2 overflow-x-auto">
                            @foreach ($q->tags as $tag)
                                <span
                                    class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full text-sm whitespace-nowrap">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Isi pertanyaan -->
                    <p class="mb-4">{{ $q->body }}</p>

                    <!-- Gambar post -->
                    @if ($q->image)
                        <div class="mb-4">
                            <a href="{{ asset('storage/' . $q->image) }}" data-lightbox="post-{{ $q->_id }}">
                                <img src="{{ asset('storage/' . $q->image) }}" alt="Gambar pertanyaan"
                                    class="rounded w-full max-h-96 object-cover cursor-pointer">
                            </a>
                        </div>
                    @endif
                </div>

                <!-- User info -->
                @php
                    $user = $q->user ?? null;
                    $profile = $user?->profile ?? null;

                    // Warna background avatar
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

                    $name = $user?->name ?? 'Guest';
                    $hash = crc32($name);
                    $bgColor = $colors[$hash % count($colors)];

                    // Inisial nama
                    $initials = collect(explode(' ', $name))
                        ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                        ->join(' ');
                @endphp


                <div class="flex justify-end items-center mt-4">
                    <div class="flex items-center">
                        <div class="text-right mr-2">
                            <p class="font-medium text-sm">{{ $name }}</p>
                            <p class="text-gray-500 text-xs">{{ $q->created_at->format('d M Y H:i') }}</p>
                        </div>

                        @if ($profile?->profile_picture)
                            <img src="{{ asset('storage/' . $profile->profile_picture) }}" alt="Profile"
                                class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $bgColor }}">
                                <span class="text-sm font-bold text-white">{{ $initials }}</span>
                            </div>
                        @endif
                    </div>
                </div>


                <!-- Likes & komentar -->
                @php
                    $liked = $q->likes()->where('user_id', Auth::id())->exists();
                @endphp
                <div class="flex items-center mt-4 text-gray-600">
                    <!-- Like button -->
                    <form action="{{ route('questions.like', $q->_id) }}" method="POST" class="inline-block mr-4">
                        @csrf
                        <button type="submit" class="focus:outline-none">
                            @if ($liked)
                                <i
                                    class="fas fa-heart text-red-500 text-xl transition-transform duration-150 hover:scale-125 animate-pulse"></i>
                            @else
                                <i
                                    class="far fa-heart text-gray-500 text-xl transition-transform duration-150 hover:scale-125"></i>
                            @endif
                        </button>
                    </form>
                    <span class="text-gray-700">{{ $q->likes()->count() }}</span>

                    <!-- Comment button -->
                    <a href="{{ route('comments.create', $q->_id) }}"
                        class="flex items-center ml-4 text-gray-600 hover:text-blue-500">
                        <i class="far fa-comment text-xl mr-1 transition-transform duration-150 hover:scale-125"></i>
                        <span>{{ $q->comments->count() }}</span>
                    </a>
                </div>

            </div>
        @endforeach

    </div>

    <!-- Lightbox2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

</body>

</html>
