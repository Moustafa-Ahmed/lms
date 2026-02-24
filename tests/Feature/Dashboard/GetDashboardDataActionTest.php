<?php

use App\Actions\Dashboard\GetDashboardDataAction;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;

test('dashboard data groups completed lesson counts per course', function () {
    $user = User::factory()->create();

    $firstCourse = Course::factory()->published()->create();
    $secondCourse = Course::factory()->published()->create();

    Enrollment::factory()->forUser($user)->forCourse($firstCourse)->create();
    Enrollment::factory()->forUser($user)->forCourse($secondCourse)->create();

    $firstCourseLessonOne = Lesson::factory()->forCourse($firstCourse)->create(['order' => 1]);
    $firstCourseLessonTwo = Lesson::factory()->forCourse($firstCourse)->create(['order' => 2]);
    $secondCourseLessonOne = Lesson::factory()->forCourse($secondCourse)->create(['order' => 1]);

    LessonProgress::factory()->forUser($user)->forLesson($firstCourseLessonOne)->completed()->create();
    LessonProgress::factory()->forUser($user)->forLesson($firstCourseLessonTwo)->completed()->create();
    LessonProgress::factory()->forUser($user)->forLesson($secondCourseLessonOne)->completed()->create();

    $incompleteLesson = Lesson::factory()->forCourse($secondCourse)->create(['order' => 2]);
    LessonProgress::factory()->forUser($user)->forLesson($incompleteLesson)->inProgress()->create();

    $data = app(GetDashboardDataAction::class)($user);

    expect($data['completedLessonsPerCourse']->toArray())->toMatchArray([
        $firstCourse->id => 2,
        $secondCourse->id => 1,
    ]);
});
