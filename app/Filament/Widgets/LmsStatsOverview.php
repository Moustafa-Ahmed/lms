<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class LmsStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $totalCourses = \App\Models\Course::query()->count();
        $totalEnrollments = Enrollment::query()->count();

        $averageCompletion = $this->calculateAverageCompletion();

        return [
            Stat::make('Total Courses', $totalCourses)
                ->description('Published and draft')
                ->icon('heroicon-o-book-open')
                ->color('primary'),

            Stat::make('Total Enrollments', $totalEnrollments)
                ->description('All time')
                ->icon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Average Completion', $averageCompletion.'%')
                ->description('Average per enrollment')
                ->icon('heroicon-o-chart-bar')
                ->color('warning'),
        ];
    }

    private function calculateAverageCompletion(): int
    {
        $totalEnrollments = Enrollment::query()->count();

        if ($totalEnrollments === 0) {
            return 0;
        }

        /** @var object{avg_completion: ?float}|null $result */
        $result = DB::selectOne('
            SELECT AVG(
                CASE
                    WHEN total_lessons.cnt = 0 THEN 0
                    ELSE ROUND(COALESCE(completed.cnt, 0) * 100.0 / total_lessons.cnt)
                END
            ) AS avg_completion
            FROM enrollments
            INNER JOIN (
                SELECT course_id, COUNT(*) AS cnt
                FROM lessons
                WHERE deleted_at IS NULL
                GROUP BY course_id
            ) AS total_lessons ON enrollments.course_id = total_lessons.course_id
            LEFT JOIN (
                SELECT lp.user_id, l.course_id, COUNT(*) AS cnt
                FROM lesson_progress lp
                INNER JOIN lessons l ON lp.lesson_id = l.id
                WHERE lp.completed_at IS NOT NULL
                AND l.deleted_at IS NULL
                GROUP BY lp.user_id, l.course_id
            ) AS completed ON enrollments.user_id = completed.user_id
                AND enrollments.course_id = completed.course_id
        ');

        return (int) round((float) ($result->avg_completion ?? 0));
    }
}
