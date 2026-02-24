<?php

namespace App\Actions\Lesson;

use App\Exceptions\EnrollmentRequiredException;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class ShowLessonAction
{
    public function __construct(private readonly GetLessonAction $getLessonAction) {}

    /**
     * @return array{
     *     course: Course,
     *     lesson: Lesson,
     *     previousLesson: ?Lesson,
     *     nextLesson: ?Lesson,
     *     isEnrolled: bool,
     *     progressUrl: string,
     *     completeUrl: string,
     *     completedLessons: array<int, int>,
     *     progressPercentage: int,
     * }
     *
     * @throws EnrollmentRequiredException
     */
    public function __invoke(Course $course, Lesson $lesson, ?User $user): array
    {
        $course->load(['lessons' => fn ($q) => $q->orderBy('order')]);

        $isEnrolled = false;
        $completedLessons = [];
        $progressPercentage = 0;

        if ($user) {
            $course->loadEnrollmentStatusFor($user);
            $isEnrolled = $user->isEnrolledIn($course);

            if (! $isEnrolled && ! $lesson->is_free_preview) {
                throw new EnrollmentRequiredException($course);
            }

            if ($isEnrolled) {
                $completedLessons = LessonProgress::query()
                    ->forUser($user)
                    ->forLessons($course->lessons->pluck('id'))
                    ->completed()
                    ->pluck('lesson_id', 'lesson_id')
                    ->toArray();

                $totalLessons = $course->lessons->count();
                $progressPercentage = $totalLessons > 0
                    ? (int) round((count($completedLessons) / $totalLessons) * 100)
                    : 0;
            }
        }

        $data = ($this->getLessonAction)($course, $lesson);

        $resolvedLesson = $data['lesson'];
        $resolvedLesson->setRelation('course', $course);

        $progressUrl = $isEnrolled ? route('lessons.progress', [$course->slug, $resolvedLesson->id]) : '';
        $completeUrl = $isEnrolled && Gate::allows('complete', $resolvedLesson)
            ? route('lessons.complete', [$course->slug, $resolvedLesson->id])
            : '';

        return [
            'course' => $course,
            'lesson' => $resolvedLesson,
            'previousLesson' => $data['previousLesson'],
            'nextLesson' => $data['nextLesson'],
            'isEnrolled' => $isEnrolled,
            'progressUrl' => $progressUrl,
            'completeUrl' => $completeUrl,
            'completedLessons' => $completedLessons,
            'progressPercentage' => $progressPercentage,
        ];
    }
}
