<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Level;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $beginner = Level::where('name', 'Beginner')->first();
        $intermediate = Level::where('name', 'Intermediate')->first();
        $advanced = Level::where('name', 'Advanced')->first();

        if (! $beginner || ! $intermediate || ! $advanced) {
            $this->command->error('Please run LevelSeeder first.');

            return;
        }

        $courses = [
            [
                'level_id' => $beginner->id,
                'title' => 'Introduction to Web Development',
                'slug' => 'introduction-to-web-development',
                'description' => 'A comprehensive beginner course covering HTML, CSS, and JavaScript fundamentals. Perfect for those starting their web development journey.',
                'is_published' => true,
            ],
            [
                'level_id' => $beginner->id,
                'title' => 'Python for Beginners',
                'slug' => 'python-for-beginners',
                'description' => 'Learn Python programming from scratch. Cover variables, data types, functions, and object-oriented programming basics.',
                'is_published' => true,
            ],
            [
                'level_id' => $beginner->id,
                'title' => 'Git and Version Control',
                'slug' => 'git-and-version-control',
                'description' => 'Master Git for version control. Learn branching, merging, pull requests, and collaboration workflows.',
                'is_published' => true,
            ],
            [
                'level_id' => $beginner->id,
                'title' => 'SQL Fundamentals',
                'slug' => 'sql-fundamentals',
                'description' => 'Learn the basics of SQL databases. Create tables, write queries, and understand relational database concepts.',
                'is_published' => true,
            ],
            [
                'level_id' => $intermediate->id,
                'title' => 'Laravel for Professionals',
                'slug' => 'laravel-for-professionals',
                'description' => 'Dive deep into Laravel framework features for building robust web applications. Covers Eloquent, queues, events, and API development.',
                'is_published' => true,
            ],
            [
                'level_id' => $intermediate->id,
                'title' => 'React Application Development',
                'slug' => 'react-application-development',
                'description' => 'Build modern single-page applications with React. Learn components, hooks, state management, and testing.',
                'is_published' => true,
            ],
            [
                'level_id' => $intermediate->id,
                'title' => 'API Design and Development',
                'slug' => 'api-design-and-development',
                'description' => 'Design and build RESTful APIs. Learn authentication, rate limiting, documentation, and best practices.',
                'is_published' => true,
            ],
            [
                'level_id' => $intermediate->id,
                'title' => 'Docker and Containerization',
                'slug' => 'docker-and-containerization',
                'description' => 'Master Docker for application containerization. Learn Docker Compose, multi-container apps, and deployment strategies.',
                'is_published' => true,
            ],
            [
                'level_id' => $advanced->id,
                'title' => 'Advanced Microservices Architecture',
                'slug' => 'advanced-microservices-architecture',
                'description' => 'Explore advanced patterns for building scalable microservices. Covers service mesh, event sourcing, and distributed tracing.',
                'is_published' => true,
            ],
            [
                'level_id' => $advanced->id,
                'title' => 'System Design Masterclass',
                'slug' => 'system-design-masterclass',
                'description' => 'Learn to design scalable systems. Cover load balancing, caching, database sharding, and high availability patterns.',
                'is_published' => false,
            ],
        ];

        $thumbnails = [
            'introduction-to-web-development' => 'introduction-to-web-development.png',
            'python-for-beginners' => 'python-for-beginners.jpg',
            'git-and-version-control' => 'git-and-version-control.jpg',
            'sql-fundamentals' => 'sql-fundamentals.jpg',
            'laravel-for-professionals' => 'laravel-for-professionals.webp',
            'react-application-development' => 'react-application-development.webp',
            'api-design-and-development' => 'api-design-and-development.jpg',
            'docker-and-containerization' => 'docker-and-containerization.jpg',
            'advanced-microservices-architecture' => 'advanced-microservices.png',
            'system-design-masterclass' => 'system-design-masterclass.jpg',
        ];

        $imagesPath = storage_path('app/public/images/courses');

        foreach ($courses as $course) {
            $model = Course::firstOrCreate(
                ['slug' => $course['slug']],
                $course
            );

            if ($model->getMedia('course_image')->isEmpty()) {
                $filename = $thumbnails[$course['slug']] ?? 'introduction-to-web-development.jpg';
                $imagePath = "{$imagesPath}/{$filename}";

                if (file_exists($imagePath)) {
                    $model->addMedia($imagePath)
                        ->preservingOriginal()
                        ->toMediaCollection('course_image');
                }
            }
        }

        $this->command->info('Created ' . count($courses) . ' courses.');
    }
}
