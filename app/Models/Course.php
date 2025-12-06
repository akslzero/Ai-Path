<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon',
    ];

    /**
     * Relasi ke Instructor (User)
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Relasi ke Modules
     */
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    /**
     * Relasi ke UserCourseProgress
     */
    public function userProgress()
    {
        return $this->hasMany(UserCourseProgress::class);
    }
}
