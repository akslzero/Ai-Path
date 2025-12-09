<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leaderboard;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Ambil semua leaderboard user berdasarkan XP
        $leaders = Leaderboard::with('user.profile')
            ->orderByDesc('weekly_xp')
            ->get();

        // Hitung rank dan badge otomatis
        $leaders->map(function ($leader, $key) {
            $leader->rank = $key + 1;

            // Badge untuk top 3
            if ($key == 0) $leader->badge = '🥇 Juara 1';
            elseif ($key == 1) $leader->badge = '🥈 Juara 2';
            elseif ($key == 2) $leader->badge = '🥉 Juara 3';
            else $leader->badge = null;

            $leader->save();
            return $leader;
        });

        return view('leaderboard', compact('leaders'));
    }

    // Tambah XP untuk user tertentu
    public function addXp(Request $request, $userId)
    {
        $xp = $request->input('xp', 10);
        $leaderboard = Leaderboard::firstOrCreate(['user_id' => $userId]);
        $leaderboard->weekly_xp += $xp;
        $leaderboard->save();

        return redirect()->back()->with('success', "$xp XP ditambahkan!");
    }
}
