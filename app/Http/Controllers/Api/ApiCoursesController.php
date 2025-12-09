<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class ApiCoursesController extends Controller
{
    public function index()
    {
        $courses = Course::with('modules')->get();
        return response()->json($courses);
    }

    public function show($id)
    {
        $course = Course::with('modules')->findOrFail($id);
        return response()->json($course);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course = Course::create($data);
        return response()->json(['message' => 'Course created', 'course' => $course], 201);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->update($data);
        return response()->json(['message' => 'Course updated', 'course' => $course]);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Course deleted']);
    }
}
