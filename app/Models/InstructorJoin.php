<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorJoin extends Model
{
    protected $fillable = [
        'username',
        'full_name',
        'email',
        'message',
    ];
}
