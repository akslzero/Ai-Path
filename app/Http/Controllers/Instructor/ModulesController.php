<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class ModulesController extends Controller
{
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('instructor.modules.create', compact('course'));
    }


    public function store(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'xp_reward' => 'nullable|integer|min:0',
        ]);

        $course->modules()->create($data);

        return redirect()->route('instructor.manage')->with('success', 'Module berhasil ditambahkan!');
    }

    public function edit($courseId, $moduleId)
    {
        $course = \App\Models\Course::findOrFail($courseId);
        $module = $course->modules()->findOrFail($moduleId);

        return view('instructor.modules.edit', compact('course', 'module'));
    }

    public function update(Request $request, $courseId, $moduleId)
    {
        $course = \App\Models\Course::findOrFail($courseId);
        $module = $course->modules()->findOrFail($moduleId);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'xp_reward' => 'nullable|integer|min:0',
        ]);

        $module->update($data);

        return redirect()->route('instructor.courses.show', $courseId)->with('success', 'Module updated!');
    }

    public function destroy($courseId, $moduleId)
    {
        $course = \App\Models\Course::findOrFail($courseId);
        $module = $course->modules()->findOrFail($moduleId);
        $module->delete();

        return redirect()->route('instructor.courses.show', $courseId)->with('success', 'Module deleted!');
    }
}
