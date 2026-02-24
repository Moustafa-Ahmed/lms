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

        $demoVideo = resource_path('demo/videos/demo.mp4');

        $lessonImagesPath = resource_path('demo/images/lessons');
        $lessonThumbnails = [
            "{$lessonImagesPath}/lesson-1.png",
            "{$lessonImagesPath}/lesson-2.jpg",
            "{$lessonImagesPath}/lesson-3.jpg",
            "{$lessonImagesPath}/lesson-4.jpg",
            "{$lessonImagesPath}/lesson-5.webp",
            "{$lessonImagesPath}/lesson-6.png",
            "{$lessonImagesPath}/lesson-7.jpg",
            "{$lessonImagesPath}/lesson-8.jpg",
            "{$lessonImagesPath}/lesson-9.jpg",
            "{$lessonImagesPath}/lesson-10.webp",
        ];

        foreach ($courses as $course) {
            $lessonCount = rand(5, 10);

            $lessonData = $this->generateLessonsForCourse($course, $lessonCount);

            foreach ($lessonData as $index => $data) {
                $lesson = Lesson::firstOrCreate(
                    [
                        'course_id' => $data['course_id'],
                        'order' => $data['order'],
                    ],
                    $data
                );

                if (file_exists($demoVideo) && ! $lesson->hasMedia('lesson_video')) {
                    $lesson->addMedia($demoVideo)
                        ->preservingOriginal()
                        ->toMediaCollection('lesson_video');
                }

                if ($lesson->getMedia('lesson_thumbnail')->isEmpty()) {
                    $thumbnailPath = $lessonThumbnails[$index % count($lessonThumbnails)];

                    if (file_exists($thumbnailPath)) {
                        $lesson->addMedia($thumbnailPath)
                            ->preservingOriginal()
                            ->toMediaCollection('lesson_thumbnail');
                    }
                }
            }

            $course->recalculateStats();
        }

        $this->command->info('Created lessons for '.$courses->count().' courses.');
    }

    private function generateLessonsForCourse(Course $course, int $count): array
    {
        $lessons = [];

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
                'duration_seconds' => rand(300, 1800),
                'is_free_preview' => $i === 1,
            ];
        }

        return $lessons;
    }
}
