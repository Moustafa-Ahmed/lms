<?php

namespace App\Actions\Lesson;

use App\Models\Course;
use App\Models\Lesson;

class GetLessonAction
{
    /** @return array{lesson: Lesson, previousLesson: ?Lesson, nextLesson: ?Lesson} */
    public function __invoke(Course $course, Lesson $lesson): array
    {
        // Use already-loaded relationship to avoid a redundant query.
        $lessons = $course->relationLoaded('lessons')
            ? $course->lessons
            : $course->lessons()->orderBy('order')->get();

        $currentIndex = $lessons->search(fn (Lesson $l) => $l->id === $lesson->id);

        return [
            'lesson' => $lesson,
            'previousLesson' => $currentIndex > 0 ? $lessons->get($currentIndex - 1) : null,
            'nextLesson' => $lessons->get($currentIndex + 1),
        ];
    }
}
