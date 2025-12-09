<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstructorRegisterController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserModuleProgressController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Forum\QuestionController;
use App\Http\Controllers\Forum\CommentController;
use App\Http\Controllers\Forum\LikeController;

use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Instructor\CoursesController as InstructorCoursesController;
use App\Http\Controllers\Instructor\ModulesController as InstructorModulesController;
use App\Http\Controllers\Instructor\LessonsController as InstructorLessonsController;
use App\Http\Controllers\AiController;





Route::post('/ai-chat', [AiController::class, 'chat']);




Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



Route::middleware(['auth', 'role:member'])->group(function () {

    Route::get('/', function () {
        return view('dashboard');
    });
    // dashboard user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // courses
    Route::get('/mycourses', [CoursesController::class, 'index'])->name('mycourses');
    Route::post('/enroll-course/{course}', [CoursesController::class, 'enroll'])->name('enroll-course');

    // modules
    Route::get('/courses/{course}/modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::post('/courses/{course}/modules', [ModuleController::class, 'store'])->name('modules.store');
    Route::delete('/modules/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');

    // user progress modules
    Route::get('/modules/{module}', [UserModuleProgressController::class, 'show'])->name('module.show');
    Route::post('/modules/{module}/complete', [UserModuleProgressController::class, 'complete'])->name('module.complete');

    // lessons
    Route::get('/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('/lessons/{lesson}/answer', [LessonController::class, 'submitAnswer'])->name('lessons.answer');

    // leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

    // join instructor page
    Route::get('/join', [InstructorRegisterController::class, 'index'])->name('join');
    Route::post('/join', [InstructorRegisterController::class, 'store'])->name('join.store');

    // profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

    // certificate
    Route::get('/certificate', [CertificateController::class, 'index'])->name('certificate');

    Route::get('/certificate/download/{course}', [CertificateController::class, 'download'])
        ->name('certificate.download');

    Route::get('/ai-chat/history', [AiController::class, 'history'])->middleware('auth');



    // settings
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    Route::post('/setting/update-profile', [SettingController::class, 'updateProfile'])->name('setting.updateProfile');
    Route::post('/setting/update-password', [SettingController::class, 'updatePassword'])->name('setting.updatePassword');
    Route::post('/setting/upload-picture', [SettingController::class, 'uploadPicture'])->name('setting.uploadPicture');
    Route::post('/setting/delete-account', [SettingController::class, 'deleteAccount'])->name('setting.deleteAccount');
});




Route::prefix('Forum')->middleware(['auth', 'role:member'])->group(function () {

    // Halaman utama forum
    Route::get('/', [QuestionController::class, 'index'])->name('forum.index');

    // Halaman submit pertanyaan baru
    Route::get('/ask', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/ask', [QuestionController::class, 'store'])->name('questions.store');

    // Halaman form komentar
    Route::get('/comment/{questionId}', [CommentController::class, 'create'])->name('comments.create');

    // Submit komentar baru
    Route::post('/comment/{questionId}', [CommentController::class, 'store'])->name('comments.store');

    Route::post('/like/{questionId}', [LikeController::class, 'toggle'])->name('questions.like');
});



Route::middleware(['auth', 'role:instructor'])
    ->prefix('instructor')
    ->name('instructor.')
    ->group(function () {
        Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/manage', [InstructorCoursesController::class, 'manage'])->name('manage');

        Route::resource('courses', InstructorCoursesController::class);
        Route::resource('courses.modules', InstructorModulesController::class);
        Route::resource('modules.lessons', InstructorLessonsController::class);
        Route::resource('courses.modules.lessons.questions', \App\Http\Controllers\Instructor\QuestionsController::class);
        Route::resource('courses.modules.lessons.questions.options', \App\Http\Controllers\Instructor\OptionLessonController::class);
    });
