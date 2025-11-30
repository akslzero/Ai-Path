<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'user_answers';

    protected $fillable = [
        'user_id',
        'question_id',
        'selected_option_id',
        'answer_text',
        'is_correct',
        'answered_at',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relasi ke OptionLesson (opsional)
     */
    public function selectedOption()
    {
        return $this->belongsTo(OptionLesson::class, 'selected_option_id');
    }
}
