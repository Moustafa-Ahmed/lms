<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Illuminate\Database\Seeder;

class LessonProgressSeeder extends Seeder
{
    public function run(): void
    {
        $learner = User::where('email', 'learner@example.com')->first();

        if (! $learner) {
            $this->command->error('Please run UserSeeder first.');

            return;
        }

        $enrollments = Enrollment::where('user_id', $learner->id)->get();

        if ($enrollments->isEmpty()) {
            $this->command->error('Please run EnrollmentSeeder first.');

            return;
        }

        foreach ($enrollments as $index => $enrollment) {
            $lessons = Lesson::where('course_id', $enrollment->course_id)->orderBy('order')->get();

            if ($lessons->isEmpty()) {
                continue;
            }

            if ($index === 0) {
                $this->createCompletedProgress($learner, $lessons);
            } elseif ($index === 1) {
                $this->createInProgressProgress($learner, $lessons);
            } elseif ($index === 2) {
                $this->createPartialProgress($learner, $lessons);
            }
        }

        $this->command->info('Created lesson progress for learner.');
    }

    private function createCompletedProgress(User $user, $lessons): void
    {
        foreach ($lessons as $lesson) {
            LessonProgress::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ],
                [
                    'watch_seconds' => $lesson->duration_seconds ?? 600,
                    'started_at' => now()->subDays(10),
                    'completed_at' => now()->subDays(10),
                ]
            );
        }
    }

    private function createInProgressProgress(User $user, $lessons): void
    {
        $halfway = (int) ($lessons->count() / 2);

        foreach ($lessons as $index => $lesson) {
            if ($index < $halfway) {
                LessonProgress::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'lesson_id' => $lesson->id,
                    ],
                    [
                        'watch_seconds' => $lesson->duration_seconds ?? 600,
                        'started_at' => now()->subDays(5)->addHours($index),
                        'completed_at' => now()->subDays(5)->addHours($index),
                    ]
                );
            } elseif ($index === $halfway) {
                LessonProgress::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'lesson_id' => $lesson->id,
                    ],
                    [
                        'watch_seconds' => (int) (($lesson->duration_seconds ?? 600) / 2),
                        'started_at' => now()->subHours(2),
                        'completed_at' => null,
                    ]
                );
            }
        }
    }

    private function createPartialProgress(User $user, $lessons): void
    {
        $firstTwo = $lessons->take(2);

        foreach ($firstTwo as $lesson) {
            LessonProgress::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ],
                [
                    'watch_seconds' => $lesson->duration_seconds ?? 600,
                    'started_at' => now()->subDays(3),
                    'completed_at' => now()->subDays(3),
                ]
            );
        }
    }
}
