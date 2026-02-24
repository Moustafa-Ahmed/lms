<?php

use App\Mail\CourseCompletionMail;
use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    Level::firstOrCreate(['name' => 'Beginner']);
});

// ── Watch-time tracking ────────────────────────────────────────────────────

it('records watch time for enrolled user', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create();
    Enrollment::create(['user_id' => $user->id, 'course_id' => $course->id]);

    $response = $this->actingAs($user)
        ->postJson(route('lessons.progress', [$course->slug, $lesson->id]), [
            'watch_seconds' => 45,
        ]);

    $response->assertOk();
    $response->assertJson(['watch_seconds' => 45]);

    $this->assertDatabaseHas('lesson_progress', [
        'user_id' => $user->id,
        'lesson_id' => $lesson->id,
        'watch_seconds' => 45,
    ]);
});

it('updates watch time on subsequent saves', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create();
    Enrollment::create(['user_id' => $user->id, 'course_id' => $course->id]);

    $this->actingAs($user)
        ->postJson(route('lessons.progress', [$course->slug, $lesson->id]), ['watch_seconds' => 10]);

    $this->actingAs($user)
        ->postJson(route('lessons.progress', [$course->slug, $lesson->id]), ['watch_seconds' => 60]);

    expect(LessonProgress::where('user_id', $user->id)->where('lesson_id', $lesson->id)->count())->toBe(1);

    $this->assertDatabaseHas('lesson_progress', [
        'user_id' => $user->id,
        'lesson_id' => $lesson->id,
        'watch_seconds' => 60,
    ]);
});

it('blocks unauthenticated watch-time tracking', function () {
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create();

    $response = $this->postJson(route('lessons.progress', [$course->slug, $lesson->id]), [
        'watch_seconds' => 30,
    ]);

    $response->assertUnauthorized();
});

it('blocks non-enrolled user from tracking watch time', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create(['is_free_preview' => false]);

    $response = $this->actingAs($user)
        ->postJson(route('lessons.progress', [$course->slug, $lesson->id]), ['watch_seconds' => 30]);

    $response->assertForbidden();
});

// ── Lesson completion ──────────────────────────────────────────────────────

it('marks a lesson as complete for enrolled user', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create(['duration_seconds' => 300]);
    Enrollment::create(['user_id' => $user->id, 'course_id' => $course->id]);

    $response = $this->actingAs($user)
        ->post(route('lessons.complete', [$course->slug, $lesson->id]));

    $response->assertRedirect();

    $this->assertDatabaseHas('lesson_progress', [
        'user_id' => $user->id,
        'lesson_id' => $lesson->id,
        'watch_seconds' => 300,
    ]);

    expect(
        LessonProgress::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->whereNotNull('completed_at')
            ->exists()
    )->toBeTrue();
});

it('is idempotent when completing the same lesson twice', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create();
    Enrollment::create(['user_id' => $user->id, 'course_id' => $course->id]);

    $this->actingAs($user)->post(route('lessons.complete', [$course->slug, $lesson->id]));
    $this->actingAs($user)->post(route('lessons.complete', [$course->slug, $lesson->id]));

    expect(
        LessonProgress::where('user_id', $user->id)->where('lesson_id', $lesson->id)->count()
    )->toBe(1);
});

it('blocks unauthenticated lesson completion', function () {
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create();

    $response = $this->post(route('lessons.complete', [$course->slug, $lesson->id]));

    $response->assertRedirect(route('login'));
});

it('blocks non-enrolled user from completing a lesson', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create(['is_free_preview' => false]);

    $response = $this->actingAs($user)
        ->post(route('lessons.complete', [$course->slug, $lesson->id]));

    $response->assertForbidden();
});

it('blocks completing a lesson from a different course', function () {
    $user = User::factory()->create();
    $courseA = Course::factory()->published()->create();
    $courseB = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($courseA)->create();
    Enrollment::create(['user_id' => $user->id, 'course_id' => $courseA->id]);

    $response = $this->actingAs($user)
        ->post(route('lessons.complete', [$courseB->slug, $lesson->id]));

    $response->assertNotFound();
});

// ── Course completion ──────────────────────────────────────────────────────

it('creates a course completion record when all lessons are done', function () {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lessons = Lesson::factory()->count(3)->for($course)->create();
    Enrollment::create(['user_id' => $user->id, 'course_id' => $course->id]);

    foreach ($lessons as $lesson) {
        $this->actingAs($user)->post(route('lessons.complete', [$course->slug, $lesson->id]));
    }

    $this->assertDatabaseHas('course_completions', [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);
});

it('sends course completion email once when all lessons are done', function () {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lessons = Lesson::factory()->count(2)->for($course)->create();
    Enrollment::create(['user_id' => $user->id, 'course_id' => $course->id]);

    foreach ($lessons as $lesson) {
        $this->actingAs($user)->post(route('lessons.complete', [$course->slug, $lesson->id]));
    }

    Mail::assertQueued(CourseCompletionMail::class, 1);
    Mail::assertQueued(CourseCompletionMail::class, fn ($mail) => $mail->hasTo($user->email));
});

it('does not send completion email again if course already completed', function () {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create();
    Enrollment::create(['user_id' => $user->id, 'course_id' => $course->id]);

    CourseCompletion::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($user)->post(route('lessons.complete', [$course->slug, $lesson->id]));

    Mail::assertNotQueued(CourseCompletionMail::class);
});

it('creates only one course completion record even when completing multiple times', function () {
    Mail::fake();

    $user = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lessons = Lesson::factory()->count(2)->for($course)->create();
    Enrollment::create(['user_id' => $user->id, 'course_id' => $course->id]);

    foreach ($lessons as $lesson) {
        $this->actingAs($user)->post(route('lessons.complete', [$course->slug, $lesson->id]));
    }

    // Complete them all again
    foreach ($lessons as $lesson) {
        $this->actingAs($user)->post(route('lessons.complete', [$course->slug, $lesson->id]));
    }

    expect(
        CourseCompletion::where('user_id', $user->id)->where('course_id', $course->id)->count()
    )->toBe(1);
});

// ── Cross-user isolation ───────────────────────────────────────────────────

it('does not write progress for other users', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create();
    Enrollment::create(['user_id' => $userA->id, 'course_id' => $course->id]);
    Enrollment::create(['user_id' => $userB->id, 'course_id' => $course->id]);

    $this->actingAs($userA)->post(route('lessons.complete', [$course->slug, $lesson->id]));

    $this->assertDatabaseMissing('lesson_progress', [
        'user_id' => $userB->id,
        'lesson_id' => $lesson->id,
    ]);
});

test('user cannot complete a lesson on behalf of another user', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();
    $course = Course::factory()->published()->create();
    $lesson = Lesson::factory()->for($course)->create(['is_free_preview' => false]);
    Enrollment::factory()->create(['user_id' => $userA->id, 'course_id' => $course->id]);

    // User B (not enrolled) tries to hit the complete endpoint
    $this->actingAs($userB)
        ->post(route('lessons.complete', [$course->slug, $lesson->id]))
        ->assertForbidden();
});
