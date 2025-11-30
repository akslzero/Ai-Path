<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forum\Comment;
use App\Models\Forum\Question;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Simpan komentar baru
    public function store(Request $request, $questionId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $question = Question::findOrFail($questionId);

        Comment::create([
            'question_id' => $question->_id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect()->route('forum.index')->with('success', 'Komentar berhasil ditambahkan!');
    }

    // Tampilkan form komentar (opsional)
    public function create($questionId)
    {
        $question = Question::findOrFail($questionId);
        return view('forum.comment', compact('question'));
    }
}
