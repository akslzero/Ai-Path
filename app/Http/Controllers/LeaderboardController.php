<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leaderboard;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Ambil top 5 user berdasarkan weekly_xp
        $leaders = Leaderboard::with('user.profile')
            ->orderByDesc('weekly_xp')
            ->take(5)
            ->get();

        return view('leaderboard', compact('leaders'));
    }
}
