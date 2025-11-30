<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $this->total_xp += $xpAmount;

        // cek level up
        while ($this->total_xp >= $threshold) {
            $this->level += 1;
            $this->total_xp -= $threshold;
        }

        $this->save();
    }
}
