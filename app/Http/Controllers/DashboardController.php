<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCourseProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $inProgress = UserCourseProgress::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->count();

        $completed = UserCourseProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $userCourses = UserCourseProgress::with('course')
            ->where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->get();

        // --- XP Harian (contoh tabel xp_logs) ---
        // struktur xp_logs: id, user_id, xp_amount, created_at
        $xpLogs = DB::table('xp_logs')
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('DAYNAME(created_at) as day, SUM(xp_amount) as total')
            ->groupBy('day')
            ->get();

        // Mapping biar urut sesuai hari (Senin → Minggu)
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $labels = [];
        $values = [];

        foreach ($days as $d) {
            $labels[] = $d;
            $found = $xpLogs->firstWhere('day', $d);
            $values[] = $found ? $found->total : 0;
        }

        $xpDays = [
            'labels' => $labels,
            'values' => $values,
        ];

        // --- Modul Completed per Hari ---
        $modulesPerDay = DB::table('user_module_progress')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('DAYNAME(updated_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->get();

        $moduleLabels = [];
        $moduleValues = [];

        foreach ($days as $d) {
            $moduleLabels[] = $d;
            $found = $modulesPerDay->firstWhere('day', $d);
            $moduleValues[] = $found ? $found->total : 0;
        }


        return view('dashboard', compact('inProgress', 'completed', 'userCourses', 'xpDays', 'moduleLabels', 'moduleValues'));
    }
}
