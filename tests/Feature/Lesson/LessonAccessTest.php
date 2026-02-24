<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Level::firstOrCreate(['name' => 'Beginner']);
});

it('allows guest to view preview lesson', function () {
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create(['is_free_preview' => true]);

    $response = $this->get(route('lessons.show', [$course->slug, $lesson->id]));

    $response->assertSuccessful();
    $response->assertSee($lesson->title);
});

it('blocks non-preview lesson for guest', function () {
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create(['is_free_preview' => false]);

    $response = $this->get(route('lessons.show', [$course->slug, $lesson->id]));

    $response->assertRedirect(route('login'));
});

it('allows enrolled user to view non-preview lesson', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create(['is_free_preview' => false]);

    Enrollment::create(['user_id' => $user->id, 'course_id' => $course->id]);

    $response = $this->actingAs($user)->get(route('lessons.show', [$course->slug, $lesson->id]));

    $response->assertSuccessful();
    $response->assertSee($lesson->title);
});

it('returns 404 for lesson-course mismatch', function () {
    $courseA = Course::factory()->published()->create();
    $courseB = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($courseA)->create();

    $response = $this->get(route('lessons.show', [$courseB->slug, $lesson->id]));

    $response->assertNotFound();
});
