<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'xp_reward',
    ];

    /**
     * Relasi ke Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relasi ke Lessons
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Relasi ke UserModuleProgress
     */
    public function userProgress()
    {
        return $this->hasMany(UserModuleProgress::class);
    }
}
