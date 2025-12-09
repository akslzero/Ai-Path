<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiCoursesController;
use App\Http\Controllers\Api\ApiModulesController;

// Semua route pakai auth:sanctum biar aman (bisa dilepas kalau mau tes tanpa token)
Route::middleware('')->group(function () {

    // -----------------------
    // Courses
    // -----------------------
    Route::get('/courses', [ApiCoursesController::class, 'index']);           // GET semua course
    Route::get('/courses/{course}', [ApiCoursesController::class, 'show']);   // GET detail course
    Route::post('/courses', [ApiCoursesController::class, 'store']);          // POST create course
    Route::put('/courses/{course}', [ApiCoursesController::class, 'update']); // PUT update course
    Route::delete('/courses/{course}', [ApiCoursesController::class, 'destroy']); // DELETE course

    // -----------------------
    // Modules per Course
    // -----------------------
    Route::get('/courses/{course}/modules', [ApiModulesController::class, 'index']);      // GET semua module
    Route::get('/courses/{course}/modules/{module}', [ApiModulesController::class, 'show']); // GET detail module
    Route::post('/courses/{course}/modules', [ApiModulesController::class, 'store']);      // POST create module
    Route::put('/courses/{course}/modules/{module}', [ApiModulesController::class, 'update']); // PUT update module
    Route::delete('/courses/{course}/modules/{module}', [ApiModulesController::class, 'destroy']); // DELETE module
});
