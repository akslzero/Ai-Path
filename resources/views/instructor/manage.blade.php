<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Manage Courses - Instructor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-sky-50 min-h-screen font-sans">

    @include('partials.ins-navbar')

    <div class="max-w-7xl mx-auto p-6">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Manage Courses</h1>
                <p class="text-sm text-slate-500">CRUD courses & modules — instructor area</p>
            </div>

            <div class="flex items-center gap-3">
                {{-- Always show Add Course (no parameter) --}}
                <a href="{{ route('instructor.courses.create') }}"
                    class="px-4 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700 text-sm">
                    + Add Course
                </a>

            </div>
        </header>


        <main class="grid grid-cols-12 gap-6">
            <!-- LEFT: Courses list -->
            <aside class="col-span-12 md:col-span-3">
                <div class="bg-white rounded-2xl shadow p-3">
                    <h2 class="text-sm font-medium text-slate-700 px-2 mb-2">Courses</h2>
                    <div class="divide-y divide-slate-100 overflow-hidden rounded-lg">
                        @forelse($courses as $course)
                            <div
                                class="flex items-center justify-between p-3 hover:bg-slate-50 {{ isset($selectedCourse) && $selectedCourse->id === $course->id ? 'bg-sky-600 text-white' : '' }}">
                                <div class="flex-1">
                                    {{-- klik course -> route instructor.courses.show --}}
                                    <a href="{{ route('instructor.courses.show', $course->id) }}"
                                        class="block font-medium {{ isset($selectedCourse) && $selectedCourse->id === $course->id ? 'text-white' : 'text-slate-800' }}">
                                        {{ $course->title }}
                                    </a>
                                    <p
                                        class="text-xs {{ isset($selectedCourse) && $selectedCourse->id === $course->id ? 'text-sky-100' : 'text-slate-400' }}">
                                        {{ Str::limit($course->description, 60) }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-slate-500">
                                Belum ada course. Klik "Add Course" untuk mulai.
                            </div>
                        @endforelse
                    </div>
                </div>
            </aside>

            <!-- RIGHT: Modules table -->
            <section class="col-span-12 md:col-span-9">
                <div class="bg-white rounded-2xl shadow p-4">
                    @if (isset($selectedCourse))
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800">{{ $selectedCourse->title }}</h3>
                                <p class="text-sm text-slate-500">{{ $selectedCourse->description }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                {{-- nested resource: route name = instructor.courses.modules.create --}}
                                <a href="{{ route('instructor.courses.modules.create', $selectedCourse->id) }}"
                                    class="px-4 py-2 bg-sky-600 text-white rounded-lg shadow hover:bg-sky-700 text-sm">
                                    + Add Module
                                </a>

                                <a href="{{ route('instructor.courses.edit', $selectedCourse->id) }}"
                                    class="px-3 py-2 border rounded-lg text-sm">Edit Course</a>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto divide-y divide-slate-100">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500">#</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500">Title</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500">XP</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500">Last Updated
                                        </th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-slate-500">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-100">
                                    @foreach ($selectedCourse->modules as $module)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-slate-700">{{ $module->id }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-800">{{ $module->title }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-700">{{ $module->xp_reward }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-500">
                                                {{ $module->updated_at->diffForHumans() }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <a href="{{ route('instructor.courses.modules.edit', [$selectedCourse->id, $module->id]) }}"
                                                    class="inline-block px-3 py-1 text-sm rounded border bg-amber-50 border-amber-200 text-amber-700 hover:bg-amber-100">
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('instructor.courses.modules.destroy', [$selectedCourse->id, $module->id]) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('Yakin hapus module ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-block px-3 py-1 text-sm rounded bg-rose-500 text-white hover:bg-rose-600">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($selectedCourse->modules->isEmpty())
                                        <tr>
                                            <td colspan="5" class="px-4 py-6 text-center text-slate-500">Belum ada
                                                module untuk course ini. Tambahkan module baru.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-16 text-center text-slate-500">
                            <svg class="mx-auto mb-4" width="64" height="64" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <path d="M12 2v20M2 12h20" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <p class="text-lg">Pilih course di kiri untuk melihat module-nya</p>
                        </div>
                    @endif
                </div>
            </section>
        </main>
    </div>

    <script>
        window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
</body>

</html>
