<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Edit Course - {{ $course->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-sky-50 min-h-screen font-sans">
    <div class="max-w-3xl mx-auto py-10">
        <div class="bg-white rounded-2xl shadow p-6">
            <h1 class="text-2xl font-semibold text-slate-800 mb-1">Edit Course</h1>
            <p class="text-slate-500 mb-6">Update data course: <b>{{ $course->title }}</b></p>

            <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-6">

                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Course Title</label>
                    <input type="text" name="title" value="{{ old('title', $course->title) }}"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                    @error('title')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full rounded-lg border-slate-300 focus:border-sky-500 focus:ring-sky-500">{{ old('description', $course->description) }}</textarea>
                    @error('description')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 🔥 Upload Icon -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Course Icon</label>

                    <!-- Preview icon lama -->
                    @if ($course->icon)
                        <div class="mb-3">
                            <p class="text-slate-600 text-sm mb-1">Current Icon:</p>
                            <img src="{{ asset('storage/' . $course->icon) }}"
                                class="h-20 w-20 object-cover rounded-lg border" alt="icon">
                        </div>
                    @endif

                    <!-- Input file -->
                    <input type="file" name="icon" accept="image/*"
                        class="w-full rounded-lg border-slate-300 bg-white cursor-pointer focus:border-sky-500 focus:ring-sky-500">

                    @error('icon')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('instructor.courses.show', $course->id) }}"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 shadow">
                        Update Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
