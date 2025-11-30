<?php

namespace App\Models\Forum;

use MongoDB\Laravel\Eloquent\Model;

class Question extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'questions';

    protected $fillable = ['user_id', 'title', 'body', 'tags', 'image'];

    // Relasi ke user SQL
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    // Relasi ke komentar
    public function comments()
    {
        return $this->hasMany(Comment::class, 'question_id', '_id');
    }

    // app/Models/Forum/Question.php

    public function likes()
    {
        return $this->hasMany(\App\Models\Forum\PostLike::class, 'question_id', '_id');
    }
}
