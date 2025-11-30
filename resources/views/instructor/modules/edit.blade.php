<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Edit Module - {{ $course->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-sky-50 min-h-screen font-sans">
    <div class="max-w-3xl mx-auto py-10">

        <!-- Header title + manage button -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-slate-800">Edit Module</h1>

            <a href="{{ route('instructor.modules.lessons.index', $module->id) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 text-white text-sm rounded-lg shadow hover:bg-sky-700 transition-all">
                Manage Lessons
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-slate-500 mb-6">
                Course: <b>{{ $course->title }}</b>
            </p>

            <form action="{{ route('instructor.courses.modules.update', [$course->id, $module->id]) }}" method="POST"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Module Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $module->title) }}"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                    @error('title')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700 mb-1">Content</label>
                    <textarea name="content" id="content" rows="5"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">{{ old('content', $module->content) }}</textarea>
                    @error('content')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="xp_reward" class="block text-sm font-medium text-slate-700 mb-1">XP Reward</label>
                    <input type="number" name="xp_reward" id="xp_reward"
                        value="{{ old('xp_reward', $module->xp_reward) }}"
                        class="w-32 rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                    @error('xp_reward')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('instructor.courses.show', $course->id) }}"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 shadow transition-all">
                        Update Module
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
