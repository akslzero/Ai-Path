<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'question_text',
        'question_type',
    ];

    /**
     * Relasi ke Lesson
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Relasi ke Options (jika multiple choice)
     */
    public function options()
    {
        return $this->hasMany(OptionLesson::class);
    }

    /**
     * Relasi ke jawaban user
     */
    public function userAnswers()
    {
        return $this->hasMany(Answer::class);
    }
}
