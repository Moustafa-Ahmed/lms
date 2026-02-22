<?php

namespace Database\Seeders;

use App\Models\CourseCompletion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseCompletionSeeder extends Seeder
{
    public function run(): void
    {
        $learner = User::where('email', 'learner@example.com')->first();

        if (! $learner) {
            $this->command->error('Please run UserSeeder first.');

            return;
        }

        $enrollments = Enrollment::where('user_id', $learner->id)->with('course')->get();

        if ($enrollments->isEmpty()) {
            $this->command->error('Please run EnrollmentSeeder first.');

            return;
        }

        $firstEnrollment = $enrollments->first();

        if (! $firstEnrollment) {
            return;
        }

        $course = $firstEnrollment->course;
        $totalLessons = Lesson::where('course_id', $course->id)->count();
        $completedLessons = Lesson::where('course_id', $course->id)
            ->whereHas('progress', function ($query) use ($learner) {
                $query->where('user_id', $learner->id)
                    ->whereNotNull('completed_at');
            })
            ->count();

        $allLessonsCompleted = $totalLessons > 0 && $totalLessons === $completedLessons;

        if ($allLessonsCompleted) {
            CourseCompletion::firstOrCreate(
                [
                    'user_id' => $learner->id,
                    'course_id' => $course->id,
                ],
                [
                    'completed_at' => now()->subDays(8),
                ]
            );

            $this->command->info('Created course completion for: ' . $course->title);
        } else {
            $this->command->info('No fully completed courses found. Skipping CourseCompletionSeeder.');
        }
    }
}
