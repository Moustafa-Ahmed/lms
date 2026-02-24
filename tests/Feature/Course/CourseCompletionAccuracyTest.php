<?php

use App\Actions\Course\FinalizeCourseCompletionAction;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Level::firstOrCreate(['name' => 'Beginner']);
});

test('course is not marked complete when a new lesson is added after completing all existing lessons', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson1 = Lesson::factory()->for($course)->create(['order' => 1]);
    $lesson2 = Lesson::factory()->for($course)->create(['order' => 2]);

    Enrollment::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);

    // Complete both lessons
    LessonProgress::factory()->create([
        'user_id' => $user->id,
        'lesson_id' => $lesson1->id,
        'completed_at' => now(),
    ]);
    LessonProgress::factory()->create([
        'user_id' => $user->id,
        'lesson_id' => $lesson2->id,
        'completed_at' => now(),
    ]);

    // Add a new lesson to the course
    Lesson::factory()->for($course)->create(['order' => 3]);

    // FinalizeCourseCompletionAction should return null (not complete)
    $action = new FinalizeCourseCompletionAction;
    $result = $action($user, $course);

    expect($result)->toBeNull();
});
