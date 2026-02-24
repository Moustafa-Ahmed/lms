<?php

use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Level;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    Level::firstOrCreate(['name' => 'Beginner']);
});

test('duplicate course slug throws unique constraint violation', function () {
    Course::factory()->create(['slug' => 'unique-slug-test']);

    expect(fn () => Course::factory()->create(['slug' => 'unique-slug-test']))
        ->toThrow(UniqueConstraintViolationException::class);
});

test('duplicate enrollment throws unique constraint violation', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    Enrollment::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);

    expect(fn () => Enrollment::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]))
        ->toThrow(UniqueConstraintViolationException::class);
});

test('duplicate lesson progress throws unique constraint violation', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create();

    LessonProgress::factory()->create(['user_id' => $user->id, 'lesson_id' => $lesson->id]);

    expect(fn () => LessonProgress::factory()->create(['user_id' => $user->id, 'lesson_id' => $lesson->id]))
        ->toThrow(UniqueConstraintViolationException::class);
});

test('completing a lesson writes both lesson_progress and triggers course_completions atomically', function () {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create(['order' => 1, 'is_free_preview' => false]);
    Enrollment::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);

    $this->actingAs($user)
        ->post(route('lessons.complete', [$course->slug, $lesson->id]));

    // Both records must exist
    expect(LessonProgress::where('user_id', $user->id)->where('lesson_id', $lesson->id)->whereNotNull('completed_at')->exists())->toBeTrue();
    expect(CourseCompletion::where('user_id', $user->id)->where('course_id', $course->id)->exists())->toBeTrue();
});

test('cannot create a course with a slug belonging to a soft-deleted course via factory', function () {
    $course = Course::factory()->create(['slug' => 'soft-delete-slug-test']);
    $course->delete(); // soft delete

    // Direct DB insert (bypassing Eloquent) would succeed — but via Eloquent create it should fail
    // because the raw Rule::unique queries the table without soft-delete scope
    expect(fn () => Course::factory()->create(['slug' => 'soft-delete-slug-test']))
        ->toThrow(UniqueConstraintViolationException::class);
});

test('restoring a course with a conflicting slug is prevented', function () {
    $courseA = Course::factory()->create(['slug' => 'conflict-slug']);
    $courseA->delete(); // soft delete

    // Temporarily rename courseA's slug in DB so courseB can claim it
    DB::table('courses')
        ->where('id', $courseA->id)
        ->update(['slug' => 'conflict-slug-renamed']);

    // Create courseB with the conflicting slug
    Course::factory()->create(['slug' => 'conflict-slug']);

    // Set courseA's in-memory slug back so the observer sees the conflict on restore
    $courseA->slug = 'conflict-slug';

    // Restoring courseA should fail (return false) because courseB now holds 'conflict-slug'
    expect($courseA->restore())->toBeFalse();

    // Verify courseA is still soft-deleted
    expect(Course::withTrashed()->find($courseA->id)->trashed())->toBeTrue();
});
