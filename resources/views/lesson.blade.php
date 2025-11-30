<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lesson->title ?? 'Lesson' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-6 relative">
        <!-- Tombol Quit (X) -->
        <!-- Tombol Quit (X) dengan popup konfirmasi -->
        <button id="quitBtn" type="button" title="Quit Lesson"
            class="absolute right-2 top-2 text-gray-400 hover:text-red-600 text-2xl font-bold z-10">&times;</button>

        <!-- Modal Konfirmasi Quit -->
        <div id="quitModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xs text-center">
                <div class="mb-4 text-lg font-semibold">Yakin mau keluar dari lesson?</div>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('modules.index', $lesson->module->course_id ?? 1) }}"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Quit</a>
                    <button id="cancelQuit" type="button"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Lanjutkan</button>
                </div>
            </div>
        </div>
        <h1 class="text-2xl font-bold mb-2 text-blue-700">{{ $lesson->title ?? '-' }}</h1>
        <p class="text-gray-700 mb-6">{{ $lesson->content ?? '' }}</p>


        @if (session('status'))
            <div class="mb-4 p-3 bg-blue-100 text-blue-800 rounded">{{ session('status') }}</div>
        @endif

        <div class="bg-white rounded shadow p-6">
            @if (session('show_continue'))
                @if (session('is_last_lesson'))
                    <form action="{{ route('module.complete', $lesson->module_id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Selesai Modul</button>
                    </form>
                @else
                    <a href="{{ route('lessons.show', session('next_lesson_id')) }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Continue</a>
                @endif
            @elseif (isset($question) && $question)
                <form action="{{ route('lessons.answer', $lesson->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <div class="font-semibold text-lg mb-2">Soal:</div>
                        <div class="mb-2">{{ $question->question_text }}</div>
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                    </div>
                    @if ($question->options->count())
                        <div class="mb-4">
                            <div class="font-semibold mb-2">Pilihan Jawaban:</div>
                            @foreach ($question->options as $option)
                                <div class="mb-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="selected_option_id" value="{{ $option->id }}"
                                            class="form-radio text-blue-600" required>
                                        <span class="ml-2">{{ $option->option_text }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Kirim
                            Jawaban</button>
                    @else
                        <div class="text-red-600">Belum ada pilihan jawaban.</div>
                    @endif
                </form>
            @else
                <div class="text-red-600">Belum ada soal untuk lesson ini.</div>
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ url()->previous() }}" class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                ← Kembali
            </a>
        </div>
    </div>
</body>
<script>
    const quitBtn = document.getElementById('quitBtn');
    const quitModal = document.getElementById('quitModal');
    const cancelQuit = document.getElementById('cancelQuit');
    if (quitBtn && quitModal && cancelQuit) {
        quitBtn.onclick = () => quitModal.classList.remove('hidden');
        cancelQuit.onclick = () => quitModal.classList.add('hidden');
    }
</script>

</html>
