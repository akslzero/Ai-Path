<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add Question - {{ $lesson->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-sky-50 min-h-screen font-sans">
    <div class="max-w-3xl mx-auto py-10">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-slate-800">Edit Question</h1>

            <!-- 👇 Tombol Manage Options -->
            <a href="{{ route('instructor.courses.modules.lessons.questions.options.index', [$course->id, $module->id, $lesson->id, $question->id]) }}"
                class="inline-block px-4 py-2 bg-sky-600 text-white text-sm rounded-lg shadow hover:bg-sky-700">
                Manage Options
            </a>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <h1 class="text-2xl font-semibold text-slate-800 mb-1">Add Question</h1>
            <p class="text-slate-500 mb-6">Lesson: <b>{{ $lesson->title }}</b></p>

            <form
                action="{{ route('instructor.courses.modules.lessons.questions.update', [$course->id, $module->id, $lesson->id, $question->id]) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label for="question_text" class="block text-sm font-medium text-slate-700 mb-1">Question
                        Text</label>
                    <input type="text" name="question_text" id="question_text" value="{{ old('question_text') }}"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                </div>

                <div>
                    <label for="question_type" class="block text-sm font-medium text-slate-700 mb-1">Question
                        Type</label>
                    <select name="question_type" id="question_type"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                        <option value="multiple_choice">Multiple Choice</option>
                        {{-- <option value="text">Text</option>
                        <option value="true_false">True/False</option> --}}
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('instructor.courses.modules.lessons.questions.index', [$course->id, $module->id, $lesson->id]) }}"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 shadow">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
