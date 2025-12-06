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

        // Hitung progress lesson di modul yg sama
        $allLessons = Lesson::where('module_id', $lesson->module_id)
            ->orderBy('id')
            ->get();

        $currentIndex = $allLessons->search(function ($item) use ($lesson) {
            return $item->id === $lesson->id;
        }) + 1; // +1 biar mulai dari 1

        $totalLessons = $allLessons->count();

        // persen progress
        $progressPercent = ($currentIndex / $totalLessons) * 100;

        return view('lesson', compact(
            'lesson',
            'question',
            'nextLesson',
            'progressPercent',
            'currentIndex',
            'totalLessons'
        ));
    }

    // Handle submit jawaban user
    public function submitAnswer(Request $request, $lesson)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'selected_option_id' => 'required|exists:option_lessons,id',
        ]);

        $user = Auth::user();
        $question = Question::with('options')->findOrFail($request->question_id);
        $option = OptionLesson::findOrFail($request->selected_option_id);

        $isCorrect = $option->is_correct;

        // simpan jawaban
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

        // cari jawaban yg benar
        $correctOption = $question->options->where('is_correct', 1)->first();

        // cari next lesson
        $lessonObj = Lesson::findOrFail($lesson);
        $nextLesson = Lesson::where('module_id', $lessonObj->module_id)
            ->where('id', '>', $lessonObj->id)
            ->orderBy('id')
            ->first();

        // data buat highlight
        $sessionData = [
            'selected_option_id' => $option->id,
            'correct_option_id' => $correctOption->id,
            'status' => $isCorrect ? 'Jawaban benar!' : 'Jawaban salah!',
        ];

        if ($isCorrect) {
            $sessionData['show_continue'] = true;
            $sessionData['next_lesson_id'] = $nextLesson ? $nextLesson->id : null;
            $sessionData['is_last_lesson'] = $nextLesson ? false : true;
        }

        return redirect()->back()->with($sessionData);
    }
}
