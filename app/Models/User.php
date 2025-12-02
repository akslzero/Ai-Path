<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function leaderboard()
    {
        return $this->hasOne(Leaderboard::class);
    }

    public function profile()
    {
        return $this->hasOne(\App\Models\UserProfile::class);
    }
    
    public function courseProgress()
    {
        return $this->hasMany(\App\Models\UserCourseProgress::class);
    }

}
