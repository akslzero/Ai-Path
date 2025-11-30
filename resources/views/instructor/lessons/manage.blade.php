<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Manage Lessons - {{ $module->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-sky-50 min-h-screen font-sans">

    @include('partials.ins-navbar')

    <div class="max-w-5xl mx-auto py-10">
        <div class="bg-white rounded-2xl shadow p-6">
            <h1 class="text-2xl font-semibold text-slate-800 mb-1">Manage Lessons</h1>
            <p class="text-slate-500 mb-6">Module: <b>{{ $module->title }}</b></p>

            <a href="{{ route('instructor.modules.lessons.create', $module->id) }}"
                class="px-4 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700">
                + Add Lesson
            </a>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full table-auto divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500">Title</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($module->lessons as $lesson)
                            <tr>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $lesson->id }}</td>
                                <td class="px-4 py-3 text-sm text-slate-800">{{ $lesson->title }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('instructor.modules.lessons.edit', [$module->id, $lesson->id]) }}"
                                        class="inline-block px-3 py-1 text-sm border rounded bg-amber-50 border-amber-200 text-amber-700 hover:bg-amber-100">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('instructor.modules.lessons.destroy', [$module->id, $lesson->id]) }}"
                                        method="POST" class="inline-block"
                                        onsubmit="return confirm('Yakin hapus lesson ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-block px-3 py-1 text-sm rounded bg-rose-500 text-white hover:bg-rose-600">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-slate-500">
                                    Belum ada lesson untuk module ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
