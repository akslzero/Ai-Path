<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModuleProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module_id',
        'status',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Module
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Tandai modul selesai
     * Bisa dipakai untuk nambah XP di UserProfile
     */
    public function markCompleted(int $xp = 10)
    {
        $this->status = 'completed';
        $this->save();

        // Tambah XP ke user profile
        if ($this->user && $this->user->profile) {
            $this->user->profile->addXp($xp);
        }
    }
}
