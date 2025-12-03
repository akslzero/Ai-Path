<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourseProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'current_module_id',
        'progress_percent',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relasi ke Module saat ini
     */
    public function currentModule()
    {
        return $this->belongsTo(Module::class, 'current_module_id');
    }

    public function setProgressPercentAttribute($value)
    {
        $this->attributes['progress_percent'] = $value;

        // kalau nilai 100%, otomatis set completed
        if ((int)$value === 100) {
            $this->attributes['status'] = 'completed';
        }
    }
}
