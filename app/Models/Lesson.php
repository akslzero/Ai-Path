<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
    ];

    /**
     * Relasi ke Module
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Relasi ke UserModuleProgress (opsional, kalau mau tracking progress per lesson)
     */
    public function userProgress()
    {
        return $this->hasMany(UserModuleProgress::class, 'module_id', 'module_id');
    }

    /**
     * Relasi ke Questions
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
