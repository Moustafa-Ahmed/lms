<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CourseController::class, 'index'])->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

Route::get('/courses/{course:slug}/lessons/{lesson}', function ($course, $lesson) {
    return redirect()->route('courses.show', $course);
})->name('lessons.show');

Route::post('/courses/{course:slug}/enroll', [CourseController::class, 'enroll'])
    ->middleware(['auth', 'verified'])
    ->name('courses.enroll');

require __DIR__.'/settings.php';
