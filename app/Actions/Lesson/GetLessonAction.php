<?php

namespace App\Actions\Lesson;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetLessonAction
{
    public function __invoke(Course $course, int $lessonId): array
    {
        $lesson = Lesson::query()
            ->where('course_id', $course->id)
            ->where('id', $lessonId)
            ->first();

        if (! $lesson) {
            throw new ModelNotFoundException('Lesson not found.');
        }

        $lessons = $course->lessons()->orderBy('order')->get();
        $currentIndex = $lessons->search(fn ($l) => $l->id === $lesson->id);

        return [
            'lesson' => $lesson,
            'previousLesson' => $currentIndex > 0 ? $lessons->get($currentIndex - 1) : null,
            'nextLesson' => $lessons->get($currentIndex + 1),
        ];
    }
}
