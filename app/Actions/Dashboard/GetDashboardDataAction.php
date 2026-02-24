<?php

namespace App\Actions\Dashboard;

use App\Models\Course;
use App\Models\LessonProgress;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class GetDashboardDataAction
{
    /**
     * @return array{
     *     enrolledCourses: LengthAwarePaginator,
     *     completedLessonsPerCourse: Collection<int, int>,
     *     completedCourseIds: Collection<int, int>,
     *     availableCourses: LengthAwarePaginator,
     * }
     */
    public function __invoke(User $user): array
    {
        $enrolledCourseIds = $user->enrollments()->pluck('course_id');

        $enrolledCourses = Course::published()
            ->enrolledIn($enrolledCourseIds)
            ->with('level', 'lessons')
            ->latest()
            ->paginate(9, ['*'], 'enrolled');

        $completedLessonsPerCourse = LessonProgress::query()
            ->selectRaw('lessons.course_id as course_id, COUNT(*) as completed_count')
            ->join('lessons', 'lessons.id', '=', 'lesson_progress.lesson_id')
            ->where('lesson_progress.user_id', $user->id)
            ->completed()
            ->groupBy('lessons.course_id')
            ->pluck('completed_count', 'course_id')
            ->map(fn ($count): int => (int) $count);

        $completedCourseIds = $user->courseCompletions()->pluck('course_id');

        $availableCourses = Course::published()
            ->notEnrolledIn($enrolledCourseIds)
            ->with('level')
            ->latest()
            ->paginate(9, ['*'], 'available');

        return [
            'enrolledCourses' => $enrolledCourses,
            'completedLessonsPerCourse' => $completedLessonsPerCourse,
            'completedCourseIds' => $completedCourseIds,
            'availableCourses' => $availableCourses,
        ];
    }
}
