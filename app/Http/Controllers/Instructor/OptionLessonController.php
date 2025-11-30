<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\OptionLesson;
use Illuminate\Http\Request;

class OptionLessonController extends Controller
{
    public function index($courseId, $moduleId, $lessonId, $questionId)
    {
        $course = Course::findOrFail($courseId);
        $module = Module::findOrFail($moduleId);
        $lesson = Lesson::findOrFail($lessonId);
        $question = Question::with('options')->findOrFail($questionId);

        return view('instructor.options.manage', compact('course', 'module', 'lesson', 'question'));
    }

    public function create($courseId, $moduleId, $lessonId, $questionId)
    {
        $course = Course::findOrFail($courseId);
        $module = Module::findOrFail($moduleId);
        $lesson = Lesson::findOrFail($lessonId);
        $question = Question::findOrFail($questionId);

        return view('instructor.options.create', compact('course', 'module', 'lesson', 'question'));
    }

    public function store(Request $request, $courseId, $moduleId, $lessonId, $questionId)
    {
        $data = $request->validate([
            'option_text' => 'required|string|max:255',
            'is_correct' => 'boolean',
        ]);

        $question = Question::findOrFail($questionId);
        $question->options()->create([
            'option_text' => $data['option_text'],
            'is_correct' => $request->has('is_correct'),
        ]);

        return redirect()->route('instructor.courses.modules.lessons.questions.options.index', [$courseId, $moduleId, $lessonId, $questionId])
            ->with('success', 'Option added successfully!');
    }

    public function edit($courseId, $moduleId, $lessonId, $questionId, $optionId)
    {
        $course = Course::findOrFail($courseId);
        $module = Module::findOrFail($moduleId);
        $lesson = Lesson::findOrFail($lessonId);
        $question = Question::findOrFail($questionId);
        $option = OptionLesson::findOrFail($optionId);

        return view('instructor.options.edit', compact('course', 'module', 'lesson', 'question', 'option'));
    }

    public function update(Request $request, $courseId, $moduleId, $lessonId, $questionId, $optionId)
    {
        $data = $request->validate([
            'option_text' => 'required|string|max:255',
            'is_correct' => 'boolean',
        ]);

        $option = OptionLesson::findOrFail($optionId);
        $option->update([
            'option_text' => $data['option_text'],
            'is_correct' => $request->has('is_correct'),
        ]);

        return redirect()->route('instructor.courses.modules.lessons.questions.options.index', [$courseId, $moduleId, $lessonId, $questionId])
            ->with('success', 'Option updated!');
    }

    public function destroy($courseId, $moduleId, $lessonId, $questionId, $optionId)
    {
        $option = OptionLesson::findOrFail($optionId);
        $option->delete();

        return redirect()->route('instructor.courses.modules.lessons.questions.options.index', [$courseId, $moduleId, $lessonId, $questionId])
            ->with('success', 'Option deleted.');
    }
}
