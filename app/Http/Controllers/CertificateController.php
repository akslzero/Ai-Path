<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\UserCourseProgress;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function index()
    {
        // ambil semua course
        $courses = Course::all();

        // Ambil progress user -> keyBy biar gampang ambil per course
        $progress = UserCourseProgress::where('user_id', Auth::id())
            ->get()
            ->keyBy('course_id');

        return view('certificate.index', compact('courses', 'progress'));
    }


    public function download(Course $course)
    {
        $user = Auth::user();

        // Ambil progress dari tabel user_course_progress
        $progress = UserCourseProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->value('progress_percent');

        // Jika belum 100%, tolak
        if (!$progress || $progress < 100) {
            abort(403, 'Course belum selesai bro 😅');
        }

        // Data buat PDF
        $data = [
            'course' => $course,
            'user' => $user,
            'date' => now()->format('d M Y'),
        ];

        $pdf = Pdf::loadView('pdf.certificatepdf', $data)->setPaper('a4', 'landscape');
        return $pdf->download('certificate-'.$course->id.'.pdf');
    }
}
