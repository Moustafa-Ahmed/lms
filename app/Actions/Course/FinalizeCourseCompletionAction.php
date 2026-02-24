<?php

namespace App\Actions\Course;

use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;

class FinalizeCourseCompletionAction
{
    /**
     * Check if all lessons in the course are complete for the user,
     * and create a CourseCompletion record if so (idempotent).
     *
     * @return CourseCompletion|null Returns the completion record if course is complete, null otherwise.
     */
    public function __invoke(User $user, Course $course): ?CourseCompletion
    {
        $lessons = $course->lessons()->get(['id']);
        $totalLessons = $lessons->count();

        if ($totalLessons === 0) {
            return null;
        }

        $completedCount = $user->lessonProgress()
            ->whereIn('lesson_id', $lessons->pluck('id'))
            ->whereNotNull('completed_at')
            ->count();

        if ($completedCount < $totalLessons) {
            return null;
        }

        try {
            return CourseCompletion::query()->create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'completed_at' => now(),
            ]);
        } catch (UniqueConstraintViolationException $exception) {
            return CourseCompletion::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->firstOrFail();
        }
    }
}
