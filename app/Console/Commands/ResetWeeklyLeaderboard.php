<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Leaderboard;

class ResetWeeklyLeaderboard extends Command
{
    protected $signature = 'leaderboard:reset-weekly';
    protected $description = 'Delete all leaderboard records for weekly reset';

    public function handle()
    {
        // Hapus semua record di leaderboard
        Leaderboard::query()->delete();

        $this->info('Weekly leaderboard has been reset! All records deleted.');
    }
}
