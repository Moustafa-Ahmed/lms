<?php

use App\Livewire\Courses\CourseCatalog;
use App\Models\Course;
use App\Models\Level;
use Livewire\Livewire;

beforeEach(function () {
    Level::factory()->create(['name' => 'Beginner']);
    Level::factory()->create(['name' => 'Intermediate']);
    Level::factory()->create(['name' => 'Advanced']);
});

it('loads initial courses on mount', function () {
    Course::factory()->published()->count(10)->create();

    Livewire::test(CourseCatalog::class)
        ->assertSet('perPage', 6)
        ->assertSee('6 of 10 courses');
});

it('shows all courses when total is less than per page', function () {
    Course::factory()->published()->count(4)->create();

    Livewire::test(CourseCatalog::class)
        ->assertSee('4 of 4 courses')
        ->assertDontSee('Load');
});

it('does not show draft courses', function () {
    Course::factory()->published()->count(3)->create();
    Course::factory()->draft()->count(5)->create();

    Livewire::test(CourseCatalog::class)
        ->assertSee('3 of 3 courses')
        ->assertDontSee('Load');
});

it('loads more courses when loadMore is called', function () {
    Course::factory()->published()->count(15)->create();

    Livewire::test(CourseCatalog::class)
        ->assertSet('perPage', 6)
        ->assertSee('6 of 15 courses')
        ->call('loadMore')
        ->assertSet('perPage', 12)
        ->assertSee('12 of 15 courses')
        ->call('loadMore')
        ->assertSet('perPage', 18)
        ->assertSee('15 of 15 courses')
        ->assertDontSee('Load');
});

it('shows empty state when no published courses', function () {
    Course::factory()->draft()->count(5)->create();

    Livewire::test(CourseCatalog::class)
        ->assertSee('0 of 0 courses')
        ->assertSee('No published courses available yet.');
});

it('calculates remaining count correctly for partial load', function () {
    Course::factory()->published()->count(8)->create();

    Livewire::test(CourseCatalog::class)
        ->assertSee('Load 2 more courses');
});
