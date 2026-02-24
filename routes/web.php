<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonCompletionController;
use App\Http\Controllers\LessonProgressController;
use App\Http\Controllers\LessonShowController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CourseController::class, 'index'])->name('home');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

Route::get('/courses/{course:slug}/lessons/{lesson}', [LessonShowController::class, 'show'])->name('lessons.show');

Route::post('/courses/{course:slug}/lessons/{lesson}/complete', [LessonCompletionController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('lessons.complete');

Route::post('/courses/{course:slug}/lessons/{lesson}/progress', [LessonProgressController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('lessons.progress');

Route::post('/courses/{course:slug}/enroll', [CourseController::class, 'enroll'])
    ->middleware(['auth', 'verified'])
    ->name('courses.enroll');

require __DIR__.'/settings.php';
