<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add Option</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-sky-50 min-h-screen font-sans">
    <div class="max-w-3xl mx-auto py-10">
        <div class="bg-white rounded-2xl shadow p-6">
            <h1 class="text-2xl font-semibold text-slate-800 mb-1">Add Option</h1>
            <p class="text-slate-500 mb-6">Untuk pertanyaan: <b>{{ $question->question_text }}</b></p>

            <form
                action="{{ route('instructor.courses.modules.lessons.questions.options.store', [$course->id, $module->id, $lesson->id, $question->id]) }}"
                method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="option_text" class="block text-sm font-medium text-slate-700 mb-1">Option Text</label>
                    <input type="text" name="option_text" id="option_text" value="{{ old('option_text') }}"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                    @error('option_text')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_correct" id="is_correct" value="1"
                        class="h-4 w-4 border-slate-300 rounded text-sky-600" {{ old('is_correct') ? 'checked' : '' }}>
                    <label for="is_correct" class="text-sm text-slate-700">Is Correct?</label>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('instructor.courses.modules.lessons.questions.options.index', [$course->id, $module->id, $lesson->id, $question->id]) }}"
                        class="px-4 py-2 border rounded-lg text-slate-600 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 shadow">
                        Save Option
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
