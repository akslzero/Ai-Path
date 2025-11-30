<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forum\Question;
use App\Models\Forum\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    // Halaman forum utama
    public function index(Request $request)
    {
        $query = $request->input('q');
        $selectedTag = $request->input('tag');

        // Ambil semua tags unik dari collection questions
        $allTags = Question::raw(function ($collection) {
            return $collection->distinct('tags');
        });

        $questions = Question::query();

        if ($query) {
            $questions->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('body', 'LIKE', "%{$query}%");
            })->orWhereHas('comments', function ($c) use ($query) {
                $c->where('body', 'LIKE', "%{$query}%");
            });
        }

        if ($selectedTag) {
            $questions->where('tags', $selectedTag);
        }

        $questions = $questions->with('user.profile', 'comments.user.profile', 'likes')
            ->latest()
            ->get();

        return view('forum.index', compact('questions', 'allTags', 'selectedTag'));
    }


    // Halaman create question
    public function create()
    {
        return view('forum.post');
    }

    // Simpan question baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'body']);
        $data['user_id'] = Auth::id();
        $data['tags'] = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        Question::create($data);

        return redirect()->route('forum.index')->with('success', 'Pertanyaan berhasil dibuat!');
    }

    // Tambah komentar ke question
    public function comment(Request $request, $questionId)
    {
        $request->validate(['body' => 'required|string']);
        $question = Question::findOrFail($questionId);

        Comment::create([
            'question_id' => $question->_id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect()->route('forum.index');
    }
}
