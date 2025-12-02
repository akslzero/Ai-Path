<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\UserCourseProgress;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller{
    public function index()
    {
        $courses = Course::all();
        $user = Auth::user();

        // ambil progress user untuk tiap course
        $progress = [];
        if ($user) {
            $progress = UserCourseProgress::where('user_id', $user->id)->pluck('progress_percent', 'course_id')->toArray();
        }

        return view('certificate', compact('courses', 'progress'));
    }
}
