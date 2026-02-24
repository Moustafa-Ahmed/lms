<?php

use App\Mail\CourseCompletionMail;
use App\Mail\WelcomeMail;
use App\Models\Course;
use App\Models\User;
use Illuminate\Queue\Middleware\WithoutOverlapping;

test('welcome mail includes without overlapping middleware', function () {
    $user = User::factory()->create();

    $middleware = (new WelcomeMail($user))->middleware();

    expect($middleware)->toHaveCount(1);
    expect($middleware[0])->toBeInstanceOf(WithoutOverlapping::class);
});

test('course completion mail includes without overlapping middleware', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create();

    $middleware = (new CourseCompletionMail($user, $course))->middleware();

    expect($middleware)->toHaveCount(1);
    expect($middleware[0])->toBeInstanceOf(WithoutOverlapping::class);
});
