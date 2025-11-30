<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    // Tampilkan semua lesson untuk module
    public function index($moduleId)
    {
        $module = Module::with('lessons')->findOrFail($moduleId);
        return view('instructor.lessons.manage', compact('module'));
    }

    // Form create
    public function create($moduleId)
    {
        $module = Module::findOrFail($moduleId);
        return view('instructor.lessons.create', compact('module'));
    }

    // Simpan lesson baru
    public function store(Request $request, $moduleId)
    {
        $module = Module::findOrFail($moduleId);

        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $module->lessons()->create($data);

        return redirect()->route('instructor.modules.lessons.index', $module->id)
            ->with('success', 'Lesson created successfully');
    }

    // Form edit
    public function edit($moduleId, $lessonId)
    {
        $module = \App\Models\Module::with('course')->findOrFail($moduleId);
        $lesson = $module->lessons()->findOrFail($lessonId);

        // ambil course lewat relasi module
        $course = $module->course;

        return view('instructor.lessons.edit', compact('course', 'module', 'lesson'));
    }

    // Update
    public function update(Request $request, $moduleId, $lessonId)
    {
        $module = Module::findOrFail($moduleId);
        $lesson = $module->lessons()->findOrFail($lessonId);

        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $lesson->update($data);

        return redirect()->route('instructor.modules.lessons.index', $module->id)
            ->with('success', 'Lesson updated successfully');
    }

    // Delete
    public function destroy($moduleId, $lessonId)
    {
        $module = Module::findOrFail($moduleId);
        $lesson = $module->lessons()->findOrFail($lessonId);
        $lesson->delete();

        return redirect()->route('instructor.modules.lessons.index', $module->id)
            ->with('success', 'Lesson deleted');
    }
}
