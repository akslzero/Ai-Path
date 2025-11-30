<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserCourseProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    // Tampilkan daftar modul dari course tertentu
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);
        $modules = $course->modules()->with(['lessons.questions'])->get();

        // ambil progress user untuk course ini
        $progress = UserCourseProgress::where('user_id', Auth::user()->id)
            ->where('course_id', $course->id)
            ->first();

        // ambil daftar course yang user terdaftar (enrolled)
        $enrolledCourses = Course::whereHas('userProgress', function ($q) {
            $q->where('user_id', Auth::user()->id);
        })->get();

        return view('modules', compact('course', 'modules', 'progress', 'enrolledCourses'));
    }
}
