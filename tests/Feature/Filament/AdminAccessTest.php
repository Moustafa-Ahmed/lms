<?php

use App\Filament\Resources\CourseResource;
use App\Filament\Resources\LevelResource;
use App\Filament\Resources\UserResource;
use App\Models\Course;
use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects guest away from admin', function () {
    $this->get('/admin')->assertRedirect('/admin/login');
});

it('blocks non-admin users from admin panel', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)->get('/admin')->assertForbidden();
});

it('allows admin users to access admin panel', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)->get('/admin')->assertSuccessful();
});

it('admin can list levels', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    Level::factory()->count(3)->create();

    $this->actingAs($admin)
        ->get(LevelResource::getUrl('index'))
        ->assertSuccessful();
});

it('admin can render level create page', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->get(LevelResource::getUrl('create'))
        ->assertSuccessful();
});

it('admin can render level edit page', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $level = Level::factory()->create();

    $this->actingAs($admin)
        ->get(LevelResource::getUrl('edit', ['record' => $level]))
        ->assertSuccessful();
});

it('admin can list courses', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    Course::factory()->count(3)->create();

    $this->actingAs($admin)
        ->get(CourseResource::getUrl('index'))
        ->assertSuccessful();
});

it('admin can render course create page', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->get(CourseResource::getUrl('create'))
        ->assertSuccessful();
});

it('admin can render course edit page', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $course = Course::factory()->create();

    $this->actingAs($admin)
        ->get(CourseResource::getUrl('edit', ['record' => $course]))
        ->assertSuccessful();
});

it('admin can list users', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    User::factory()->count(3)->create();

    $this->actingAs($admin)
        ->get(UserResource::getUrl('index'))
        ->assertSuccessful();
});

it('non-admin cannot access level pages', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)
        ->get(LevelResource::getUrl('index'))
        ->assertForbidden();
});

it('non-admin cannot access course pages', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)
        ->get(CourseResource::getUrl('index'))
        ->assertForbidden();
});
