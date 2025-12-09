<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ApiModulesController extends Controller
{
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);
        $modules = $course->modules()->get();

        return response()->json($modules);
    }

    public function show($courseId, $moduleId)
    {
        $course = Course::findOrFail($courseId);
        $module = $course->modules()->findOrFail($moduleId);

        return response()->json($module);
    }

    public function store(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'xp_reward' => 'nullable|integer|min:0',
        ]);

        $module = $course->modules()->create($data);

        return response()->json(['message' => 'Module created', 'module' => $module], 201);
    }

    public function update(Request $request, $courseId, $moduleId)
    {
        $course = Course::findOrFail($courseId);
        $module = $course->modules()->findOrFail($moduleId);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'xp_reward' => 'nullable|integer|min:0',
        ]);

        $module->update($data);
        return response()->json(['message' => 'Module updated', 'module' => $module]);
    }

    public function destroy($courseId, $moduleId)
    {
        $course = Course::findOrFail($courseId);
        $module = $course->modules()->findOrFail($moduleId);
        $module->delete();

        return response()->json(['message' => 'Module deleted']);
    }
}
