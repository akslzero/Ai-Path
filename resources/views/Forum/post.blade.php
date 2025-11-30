<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ask Question</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    @include('partials.navbar')

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Ask a Question</h1>

        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
            <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Judul -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Judul Pertanyaan</label>
                    <input type="text" name="title" placeholder="Masukkan judul" class="w-full border rounded p-2"
                        required>
                </div>

                <!-- Isi Pertanyaan -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Isi Pertanyaan</label>
                    <textarea name="body" placeholder="Tulis pertanyaanmu di sini..." class="w-full border rounded p-2 h-32" required></textarea>
                </div>

                <!-- Tags -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Tags (pisahkan pakai koma)</label>
                    <input type="text" name="tags" placeholder="tag1,tag2,tag3" class="w-full border rounded p-2">
                </div>

                <!-- Upload Gambar -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Upload Gambar (opsional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full">
                </div>

                <!-- Submit -->
                <div class="mb-4">
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                        Submit Question
                    </button>
                    <a href="{{ route('forum.index') }}" class="ml-4 text-gray-700 hover:underline">Batal</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
