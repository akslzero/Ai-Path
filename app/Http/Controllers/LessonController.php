<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\OptionLesson;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    // Tampilkan lesson beserta soal dan pilihan jawaban
    public function show($lesson)
    {
        $lesson = Lesson::with(['module'])->findOrFail($lesson);
        $question = Question::with('options')->where('lesson_id', $lesson->id)->first();

        // Cari lesson berikutnya dalam modul yang sama
        $nextLesson = Lesson::where('module_id', $lesson->module_id)
            ->where('id', '>', $lesson->id)
            ->orderBy('id')
            ->first();

        return view('lesson', compact('lesson', 'question', 'nextLesson'));
    }

    // Handle submit jawaban user
    public function submitAnswer(Request $request, $lesson)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'selected_option_id' => 'required|exists:option_lessons,id',
        ]);

        $user = Auth::user();
        $question = Question::findOrFail($request->question_id);
        $option = OptionLesson::findOrFail($request->selected_option_id);

        $isCorrect = $option->is_correct;

        // Simpan jawaban user
        Answer::updateOrCreate(
            [
                'user_id' => $user->id,
                'question_id' => $question->id,
            ],
            [
                'selected_option_id' => $option->id,
                'is_correct' => $isCorrect,
                'answered_at' => now(),
            ]
        );

        // Cari lesson berikutnya dalam modul yang sama
        $lessonObj = Lesson::findOrFail($lesson);
        $nextLesson = Lesson::where('module_id', $lessonObj->module_id)
            ->where('id', '>', $lessonObj->id)
            ->orderBy('id')
            ->first();

        if ($isCorrect) {
            return redirect()->back()->with([
                'status' => 'Jawaban benar!',
                'show_continue' => true,
                'next_lesson_id' => $nextLesson ? $nextLesson->id : null,
                'is_last_lesson' => $nextLesson ? false : true,
            ]);
        }
        return redirect()->back()->with('status', 'Jawaban salah!');
    }
}
