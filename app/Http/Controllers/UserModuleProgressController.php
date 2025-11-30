<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\UserModuleProgress;
use App\Models\UserCourseProgress;
use Illuminate\Support\Facades\Auth;
use App\Models\Leaderboard;

class UserModuleProgressController extends Controller
{
    // buka modul (ubah status jadi in_progress)
    public function show(Module $module)
    {
        $user = Auth::user();

        // update atau buat progress user
        $progress = UserModuleProgress::firstOrCreate(
            ['user_id' => $user->id, 'module_id' => $module->id],
            ['status' => 'in_progress']
        );

        if ($progress->status === 'not_started') {
            $progress->update(['status' => 'in_progress']);
        }

        return view('lesson', compact('module', 'progress'));
    }

    // tandai selesai modul (set completed)
    public function complete($moduleId)
    {
        $user = Auth::user();
        $module = Module::findOrFail($moduleId);

        // update status modul
        $progress = UserModuleProgress::updateOrCreate(
            ['user_id' => $user->id, 'module_id' => $moduleId],
            ['status' => 'completed']
        );

        // Tambah XP ke user profile

        $profile = $user->profile;
        if ($profile) {
            $profile->addXp($module->xp_reward ?? 10);
        }

        $xpReward = $module->xp_reward ?? 10;
        // Tambah XP ke leaderboard mingguan
        $leaderboard = Leaderboard::firstOrCreate(['user_id' => $user->id]);
        $leaderboard->increment('weekly_xp', $xpReward);

        // hitung ulang progress kursus
        $course = $module->course;
        $totalModules = $course->modules()->count();
        $completedModules = UserModuleProgress::where('user_id', $user->id)
            ->whereIn('module_id', $course->modules->pluck('id'))
            ->where('status', 'completed')
            ->count();

        $percent = $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;

        // simpan ke user_course_progress
        UserCourseProgress::updateOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['progress_percent' => $percent]
        );

        // kalau semua modul selesai, tandai course-nya complete juga
        if ($percent === 100) {
            UserCourseProgress::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->update(['status' => 'completed']);
        }

        return redirect()->route('modules.index', $course->id);
    }
}
