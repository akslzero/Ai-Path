<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add Lesson - {{ $module->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-sky-50 min-h-screen font-sans">
    <div class="max-w-3xl mx-auto py-10">
        <div class="bg-white rounded-2xl shadow p-6">
            <h1 class="text-2xl font-semibold text-slate-800 mb-4">Add Lesson</h1>

            <form action="{{ route('instructor.modules.lessons.store', $module->id) }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Lesson Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                    @error('title')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('instructor.modules.lessons.index', $module->id) }}"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 shadow">
                        Save Lesson
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
