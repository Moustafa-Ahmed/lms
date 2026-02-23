<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Level::firstOrCreate(['name' => 'Beginner']);
    Level::firstOrCreate(['name' => 'Intermediate']);
    Level::firstOrCreate(['name' => 'Advanced']);
});

it('lists only published courses on home', function () {
    $published = Course::factory()->published()->create(['title' => 'Published Course']);
    $draft = Course::factory()->draft()->create(['title' => 'Draft Course']);

    $response = $this->get(route('home'));

    $response->assertSuccessful();
    $response->assertSee('Published Course');
    $response->assertDontSee('Draft Course');
});

it('shows course entry page for published courses', function () {
    $course = Course::factory()->published()->create();

    $response = $this->get(route('courses.show', $course->slug));

    $response->assertSuccessful();
    $response->assertSee($course->title);
});

it('returns 404 for draft courses on course entry page', function () {
    $course = Course::factory()->draft()->create();

    $response = $this->get(route('courses.show', $course->slug));

    $response->assertNotFound();
});

it('allows guest to view course page', function () {
    $course = Course::factory()->published()->create();

    $response = $this->get(route('courses.show', $course->slug));

    $response->assertSuccessful();
});

it('redirects guest to login when enrolling', function () {
    $course = Course::factory()->published()->create();

    $response = $this->post(route('courses.enroll', $course->slug));

    $response->assertRedirect(route('login'));
});

it('allows authenticated user to enroll in published course', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $response = $this->actingAs($user)->post(route('courses.enroll', $course->slug));

    $response->assertRedirect(route('courses.show', $course->slug));
    $this->assertDatabaseHas('enrollments', [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);
});

it('returns 404 when enrolling in draft course', function () {
    $user = User::factory()->create();
    $course = Course::factory()->draft()->create();

    $response = $this->actingAs($user)->post(route('courses.enroll', $course->slug));

    $response->assertNotFound();
    $this->assertDatabaseMissing('enrollments', [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);
});

it('is idempotent when enrolling multiple times', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $this->actingAs($user)->post(route('courses.enroll', $course->slug));
    $this->actingAs($user)->post(route('courses.enroll', $course->slug));

    $count = Enrollment::where('user_id', $user->id)
        ->where('course_id', $course->id)
        ->count();

    expect($count)->toBe(1);
});
