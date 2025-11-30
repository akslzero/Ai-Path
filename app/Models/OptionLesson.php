<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionLesson extends Model
{
    use HasFactory;

    protected $table = 'option_lessons'; // nama tabel sesuai migration

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
    ];

    /**
     * Relasi ke Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relasi ke UserAnswer (opsional)
     */
    public function userAnswers()
    {
        return $this->hasMany(Answer::class, 'selected_option_id');
    }
}
