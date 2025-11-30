<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add Module - {{ $course->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-sky-50 min-h-screen font-sans">
    <div class="max-w-3xl mx-auto py-10">
        <div class="bg-white rounded-2xl shadow p-6">
            <h1 class="text-2xl font-semibold text-slate-800 mb-1">Add Module</h1>
            <p class="text-slate-500 mb-6">Tambahkan modul baru untuk course: <b>{{ $course->title }}</b></p>

            <form action="{{ route('instructor.courses.modules.store', $course->id) }}" method="POST"
                class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Module Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700 mb-1">Content</label>
                    <textarea name="content" id="content" rows="5"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">{{ old('content') }}</textarea>
                </div>

                <div>
                    <label for="xp_reward" class="block text-sm font-medium text-slate-700 mb-1">XP Reward</label>
                    <input type="number" name="xp_reward" id="xp_reward" value="{{ old('xp_reward', 10) }}"
                        class="w-32 rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('instructor.manage') }}"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 shadow">
                        Save Module
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
