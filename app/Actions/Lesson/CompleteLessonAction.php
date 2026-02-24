<?php

namespace App\Actions\Lesson;

use App\Actions\Course\FinalizeCourseCompletionAction;
use App\Actions\Course\SendCourseCompletionEmailAction;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;

class CompleteLessonAction
{
    public function __construct(
        private readonly RecordLessonCompletionAction $recordCompletion,
        private readonly FinalizeCourseCompletionAction $finalizeCourseCompletion,
        private readonly SendCourseCompletionEmailAction $sendCompletionEmail,
    ) {}

    /**
     * @return array{nextLesson: ?Lesson, courseJustCompleted: bool}
     */
    public function __invoke(User $user, Lesson $lesson, Course $course): array
    {
        ($this->recordCompletion)($user, $lesson);

        $courseCompletion = ($this->finalizeCourseCompletion)($user, $course);

        $courseJustCompleted = $courseCompletion !== null && $courseCompletion->wasRecentlyCreated;

        if ($courseJustCompleted) {
            ($this->sendCompletionEmail)($user, $course);
        }

        $nextLesson = $course->lessons()
            ->where('order', '>', $lesson->order)
            ->orderBy('order')
            ->first();

        $canAccessNext = $nextLesson !== null
            && ($nextLesson->is_free_preview || $user->isEnrolledIn($course));

        return [
            'nextLesson' => $canAccessNext ? $nextLesson : null,
            'courseJustCompleted' => $courseJustCompleted,
        ];
    }
}
