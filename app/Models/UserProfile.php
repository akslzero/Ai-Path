<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserProfile extends Model
{
    use HasFactory;

    protected $connection = 'mysql';


    protected $fillable = [
        'user_id',
        'profile_picture',
        'level',
        'total_xp',
        'role',
        'bio',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tambah XP dan cek level up
     *
     * @param int $xpAmount
     * @param int $threshold
     * @return void
     */
    public function addXp(int $xpAmount, int $threshold = 100)
    {
        // Tambah XP
        $this->total_xp += $xpAmount;

        DB::table('xp_logs')->insert([
            'user_id' => $this->user_id,
            'xp_amount' => $xpAmount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Cek level up (bisa sekaligus naik beberapa level)
        while ($this->total_xp >= $threshold) {
            $this->level++;
            $this->total_xp -= $threshold;
        }

        $this->save();
    }
}
