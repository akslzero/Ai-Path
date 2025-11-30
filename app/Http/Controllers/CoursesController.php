<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\UserCourseProgress;
use Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $user = Auth::user();

        // ambil progress user untuk tiap course
        $progress = [];
        if ($user) {
            $progress = UserCourseProgress::where('user_id', $user->id)->pluck('progress_percent', 'course_id')->toArray();
        }

        return view('mycourses', compact('courses', 'progress'));
    }

    public function enroll(Course $course)
    {
        $user = Auth::user();

        // cek apakah user sudah terdaftar
        $progress = UserCourseProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id
            ],
            [
                'status' => 'in_progress',
                'progress_percent' => 0
            ]
        );

        return back()->with('success', 'Kamu berhasil terdaftar di course ini!');
    }
}
