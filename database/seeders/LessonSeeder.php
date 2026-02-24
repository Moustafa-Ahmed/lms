<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();

        if ($courses->isEmpty()) {
            $this->command->error('Please run CourseSeeder first.');

            return;
        }

        foreach ($courses as $course) {
            $lessonCount = rand(5, 10);

            $lessonData = $this->generateLessonsForCourse($course, $lessonCount);

            foreach ($lessonData as $data) {
                Lesson::firstOrCreate(
                    [
                        'course_id' => $data['course_id'],
                        'order' => $data['order'],
                    ],
                    $data
                );
            }

            $course->recalculateStats();
        }

        $this->command->info('Created lessons for '.$courses->count().' courses.');
    }

    private function generateLessonsForCourse(Course $course, int $count): array
    {
        $lessons = [];
        $videoPath = asset('storage/videos/demo.mp4');

        $titles = [
            'Welcome & Course Overview',
            'Getting Started',
            'Core Concepts',
            'Deep Dive',
            'Practical Examples',
            'Common Pitfalls',
            'Best Practices',
            'Advanced Techniques',
            'Real-World Application',
            'Course Summary & Next Steps',
        ];

        for ($i = 1; $i <= $count; $i++) {
            $lessons[] = [
                'course_id' => $course->id,
                'title' => $titles[$i - 1] ?? "Lesson {$i}",
                'order' => $i,
                'video_url' => $videoPath,
                'duration_seconds' => rand(300, 1800),
                'is_free_preview' => $i === 1,
            ];
        }

        return $lessons;
    }
}
