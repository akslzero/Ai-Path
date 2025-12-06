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

        <!-- Quit Button -->
        <button id="quitBtn" type="button" title="Quit Lesson"
            class="absolute right-2 top-2 text-gray-400 hover:text-red-600 text-2xl font-bold z-10">&times;</button>

        <!-- Quit Modal -->
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

        <div class="space-y-4">


            @if (isset($question) && $question)

                {{-- PROGRESS BAR --}}
                <div class="w-full bg-gray-200 h-2 rounded-full mb-4 overflow-hidden">
                    <div class="h-full bg-green-500 transition-all duration-300"
                        style="width: {{ $progressPercent }}%;"></div>
                </div>

                <div class="text-sm text-gray-600 mb-4">
                    {{ $currentIndex }} / {{ $totalLessons }}
                </div>


                <!-- Soal & Jawaban -->
                <form action="{{ route('lessons.answer', $lesson->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <div class="mb-2">{{ $question->question_text }}</div>
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                    </div>

                    @php
                        $selected = session('selected_option_id');
                        $correct = session('correct_option_id');
                    @endphp

                    @if ($question->options->count())
                        <div class="mb-4">


                            @php
                                $selected = session('selected_option_id');
                                $correct = session('correct_option_id');
                            @endphp

                            @foreach ($question->options as $option)
                                @php
                                    if ($selected) {
                                        // Jika sudah submit → apply warna benar / salah
                                        if ($selected == $correct && $option->id == $correct) {
                                            $boxClass =
                                                'bg-green-200 border-green-500 shadow-[0_4px_0_rgba(0,0,0,0.15)]';
                                        } elseif ($selected != $correct && $option->id == $selected) {
                                            $boxClass = 'bg-red-200 border-red-500 shadow-[0_4px_0_rgba(0,0,0,0.15)]';
                                        } else {
                                            $boxClass = 'bg-white border-gray-300 shadow-[0_4px_0_rgba(0,0,0,0.15)]';
                                        }
                                    } else {
                                        // BELUM submit → jangan kasih warna apapun biar bisa diubah JS
                                        $boxClass =
                                            'option-default bg-white border-gray-300 shadow-[0_4px_0_rgba(0,0,0,0.15)]';
                                    }
                                @endphp

                                <label class="block mb-3">
                                    <div class="option-box p-3 border rounded-lg flex items-center cursor-pointer {{ $boxClass }}"
                                        data-option="{{ $option->id }}">

                                        <input type="radio" name="selected_option_id" value="{{ $option->id }}"
                                            class="real-radio hidden" @if ($selected) disabled @endif
                                            required>

                                        <span class="text-gray-800">{{ $option->option_text }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>






                        <!-- Tombol Kirim HANYA muncul sebelum menjawab -->
                        @if (!$selected)
                            <div
                                class="fixed bottom-0 left-0 w-full bg-blue-100 border-t border-blue-300 p-4 flex justify-center">

                                <button type="submit" id="checkBtn"
                                    class="px-6 py-3 bg-gray-400 text-white font-semibold shadow-md cursor-not-allowed transition"
                                    disabled>
                                    Check
                                </button>

                            </div>
                        @endif

                        <script>
                            document.addEventListener('DOMContentLoaded', () => {

                                const btn = document.getElementById('checkBtn');
                                if (!btn) return; // tombol emang belum ada kalau sudah submit

                                const optionBoxes = document.querySelectorAll('.option-box');

                                optionBoxes.forEach(box => {
                                    box.addEventListener('click', () => {

                                        // Saat user klik → cek radio
                                        const radio = box.querySelector('input.real-radio');
                                        if (radio) {
                                            radio.checked = true;
                                        }

                                        // ====== RESET WARNA BOX (SELAMA BELUM SUBMIT) ======
                                        optionBoxes.forEach(b => {
                                            if (b.classList.contains('option-default')) {
                                                b.classList.remove('bg-blue-100', 'border-blue-400');
                                                b.classList.add('bg-white', 'border-gray-300');
                                            }
                                        });

                                        // ====== SET WARNA BOX YANG DIKLIK ======
                                        if (box.classList.contains('option-default')) {
                                            box.classList.remove('bg-white', 'border-gray-300');
                                            box.classList.add('bg-blue-100', 'border-blue-400');
                                        }

                                        // ====== AKTIVKAN TOMBOL ======
                                        btn.disabled = false;
                                        btn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                                        btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                                    });
                                });

                            });
                        </script>
                    @else
                        <div class="text-red-600">Belum ada pilihan jawaban.</div>
                    @endif

                </form>

                @if (session('show_continue'))
                    <div
                        class="fixed bottom-0 left-0 w-full bg-blue-100 border-t border-blue-300 p-4 flex justify-center">

                        @if (session('is_last_lesson'))
                            <form action="{{ route('module.complete', $lesson->module_id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 active:scale-[0.98] transition">
                                    Selesai Modul
                                </button>
                            </form>
                        @else
                            <a href="{{ route('lessons.show', session('next_lesson_id')) }}"
                                class="px-6 py-3 bg-green-600 text-white font-semibold shadow-md hover:bg-green-700 active:scale-[0.98] transition">
                                Continue
                            </a>
                        @endif

                    </div>
                @endif
            @else
                <div class="text-red-600">Belum ada soal untuk lesson ini.</div>
            @endif
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
