<?php

namespace App\Actions\Dashboard;

use App\Models\Course;
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

        $completedLessonsPerCourse = $user->lessonProgress()
            ->with('lesson')
            ->completed()
            ->get()
            ->groupBy(fn ($lp) => $lp->lesson->course_id ?? null)
            ->map->count();

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
