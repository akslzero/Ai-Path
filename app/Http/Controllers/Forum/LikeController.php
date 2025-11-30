<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forum\PostLike;
use App\Models\Forum\Question;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($questionId)
    {
        $question = Question::findOrFail($questionId);
        $userId = Auth::id();

        // Cek apakah user sudah like
        $like = PostLike::where('question_id', $question->_id)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            // Hapus like
            $like->delete();
        } else {
            // Tambah like
            PostLike::create([
                'question_id' => $question->_id,
                'user_id' => $userId
            ]);
        }

        return redirect()->back();
    }
}
