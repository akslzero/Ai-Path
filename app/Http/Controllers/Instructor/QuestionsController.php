<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index($courseId, $moduleId, $lessonId)
    {
        $lesson = Lesson::with('questions')->findOrFail($lessonId);
        $module = Module::findOrFail($moduleId);
        $course = Course::findOrFail($courseId);

        return view('instructor.questions.manage', compact('course', 'module', 'lesson'));
    }

    public function create($courseId, $moduleId, $lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $course = Course::findOrFail($courseId);
        $module = Module::findOrFail($moduleId);

        return view('instructor.questions.create', compact('course', 'module', 'lesson'));
    }

    public function store(Request $request, $courseId, $moduleId, $lessonId)
    {
        $data = $request->validate([
            'question_text' => 'required|string|max:255',
            'question_type' => 'required|string|max:50',
        ]);

        $data['lesson_id'] = $lessonId;
        Question::create($data);

        return redirect()->route('instructor.courses.modules.lessons.questions.index', [$courseId, $moduleId, $lessonId])
            ->with('success', 'Question added successfully');
    }

    public function edit($courseId, $moduleId, $lessonId, $id)
    {
        $question = Question::findOrFail($id);
        $lesson = Lesson::findOrFail($lessonId);
        $course = Course::findOrFail($courseId);
        $module = Module::findOrFail($moduleId);

        return view('instructor.questions.edit', compact('question', 'course', 'module', 'lesson'));
    }

    public function update(Request $request, $courseId, $moduleId, $lessonId, $id)
    {
        $question = Question::findOrFail($id);

        $data = $request->validate([
            'question_text' => 'required|string|max:255',
            'question_type' => 'required|string|max:50',
        ]);

        $question->update($data);

        return redirect()->route('instructor.courses.modules.lessons.questions.index', [$courseId, $moduleId, $lessonId])
            ->with('success', 'Question updated successfully');
    }

    public function destroy($courseId, $moduleId, $lessonId, $id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('instructor.courses.modules.lessons.questions.index', [$courseId, $moduleId, $lessonId])
            ->with('success', 'Question deleted successfully');
    }
}
