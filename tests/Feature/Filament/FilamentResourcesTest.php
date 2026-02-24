<?php

use App\Filament\Resources\CourseResource;
use App\Filament\Resources\CourseResource\Pages\EditCourse;
use App\Filament\Resources\CourseResource\RelationManagers\EnrollmentsRelationManager as CourseEnrollmentsRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\LessonsRelationManager;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Filament\Resources\UserResource\RelationManagers\EnrollmentsRelationManager as UserEnrollmentsRelationManager;
use App\Filament\Widgets\LmsStatsOverview;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Livewire\Livewire;

test('lessons relation manager renders on course edit page', function () {
    $admin = User::factory()->admin()->create();
    $course = Course::factory()->create();
    Lesson::factory()->count(3)->for($course)->create();

    $this->actingAs($admin)
        ->get(CourseResource::getUrl('edit', ['record' => $course]))
        ->assertOk()
        ->assertSee('Lessons');
});

test('admin can see lessons in lessons relation manager', function () {
    $admin = User::factory()->admin()->create();
    $course = Course::factory()->create();
    $lesson = Lesson::factory()->for($course)->create();

    Livewire::actingAs($admin)
        ->test(LessonsRelationManager::class, [
            'ownerRecord' => $course,
            'pageClass' => EditCourse::class,
        ])
        ->assertCanSeeTableRecords([$lesson]);
});

test('enrollments relation manager renders on course page', function () {
    $admin = User::factory()->admin()->create();
    $course = Course::factory()->published()->create();
    $learner = User::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $learner->id, 'course_id' => $course->id]);

    Livewire::actingAs($admin)
        ->test(CourseEnrollmentsRelationManager::class, [
            'ownerRecord' => $course,
            'pageClass' => EditCourse::class,
        ])
        ->assertCanSeeTableRecords([$enrollment]);
});

test('enrollments relation manager renders on user page', function () {
    $admin = User::factory()->admin()->create();
    $learner = User::factory()->create();
    $course = Course::factory()->published()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $learner->id, 'course_id' => $course->id]);

    Livewire::actingAs($admin)
        ->test(UserEnrollmentsRelationManager::class, [
            'ownerRecord' => $learner,
            'pageClass' => ViewUser::class,
        ])
        ->assertCanSeeTableRecords([$enrollment]);
});

test('admin cannot access user create page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/users/create')
        ->assertNotFound();
});

test('admin cannot access user edit page', function () {
    $admin = User::factory()->admin()->create();
    $learner = User::factory()->create();

    $this->actingAs($admin)
        ->get('/admin/users/'.$learner->id.'/edit')
        ->assertNotFound();
});

test('dashboard widget renders total courses, enrollments and avg completion', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(LmsStatsOverview::class)
        ->assertSee('Total Courses')
        ->assertSee('Total Enrollments')
        ->assertSee('Average Completion');
});
