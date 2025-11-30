<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    // /instructor/manage -> list semua course (belum select)
    public function index()
    {
        $courses = Course::with('modules')->get();
        $selectedCourse = null;
        return view('instructor.manage', compact('courses', 'selectedCourse'));
    }

    // /instructor/courses/{id} -> nampilin manage + selected course
    public function show($id)
    {
        $courses = Course::all();
        $selectedCourse = Course::with('modules')->findOrFail($id);

        return view('instructor.manage', compact('courses', 'selectedCourse'));
    }

    public function create()
    {
        return view('instructor.courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Course::create($data);
        return redirect()->route('instructor.manage')->with('success', 'Course created');
    }

    public function edit(Course $course)
    {
        return view('instructor.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->update($data);
        return redirect()->route('instructor.courses.show', $course->id)->with('success', 'Course updated');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('instructor.manage')->with('success', 'Course deleted');
    }

    public function manage()
    {
        // ambil semua course, tapi belum ada yang dipilih
        $courses = Course::all();

        return view('instructor.manage', [
            'courses' => $courses,
            'selectedCourse' => null, // biar gak undefined
        ]);
    }
}
