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
                'image_url' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&q=80',
                'is_published' => true,
            ],
            [
                'level_id' => $beginner->id,
                'title' => 'Python for Beginners',
                'slug' => 'python-for-beginners',
                'description' => 'Learn Python programming from scratch. Cover variables, data types, functions, and object-oriented programming basics.',
                'image_url' => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=800&q=80',
                'is_published' => true,
            ],
            [
                'level_id' => $beginner->id,
                'title' => 'Git and Version Control',
                'slug' => 'git-and-version-control',
                'description' => 'Master Git for version control. Learn branching, merging, pull requests, and collaboration workflows.',
                'image_url' => 'https://images.unsplash.com/photo-1556075798-4825dfaaf498?w=800&q=80',
                'is_published' => true,
            ],
            [
                'level_id' => $beginner->id,
                'title' => 'SQL Fundamentals',
                'slug' => 'sql-fundamentals',
                'description' => 'Learn the basics of SQL databases. Create tables, write queries, and understand relational database concepts.',
                'image_url' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=800&q=80',
                'is_published' => true,
            ],
            [
                'level_id' => $intermediate->id,
                'title' => 'Laravel for Professionals',
                'slug' => 'laravel-for-professionals',
                'description' => 'Dive deep into Laravel framework features for building robust web applications. Covers Eloquent, queues, events, and API development.',
                'image_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&q=80',
                'is_published' => true,
            ],
            [
                'level_id' => $intermediate->id,
                'title' => 'React Application Development',
                'slug' => 'react-application-development',
                'description' => 'Build modern single-page applications with React. Learn components, hooks, state management, and testing.',
                'image_url' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=800&q=80',
                'is_published' => true,
            ],
            [
                'level_id' => $intermediate->id,
                'title' => 'API Design and Development',
                'slug' => 'api-design-and-development',
                'description' => 'Design and build RESTful APIs. Learn authentication, rate limiting, documentation, and best practices.',
                'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&q=80',
                'is_published' => true,
            ],
            [
                'level_id' => $intermediate->id,
                'title' => 'Docker and Containerization',
                'slug' => 'docker-and-containerization',
                'description' => 'Master Docker for application containerization. Learn Docker Compose, multi-container apps, and deployment strategies.',
                'image_url' => 'https://images.unsplash.com/photo-1667372393119-3d4c48d07fc9?w=800&q=80',
                'is_published' => true,
            ],
            [
                'level_id' => $advanced->id,
                'title' => 'Advanced Microservices Architecture',
                'slug' => 'advanced-microservices-architecture',
                'description' => 'Explore advanced patterns for building scalable microservices. Covers service mesh, event sourcing, and distributed tracing.',
                'image_url' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&q=80',
                'is_published' => true,
            ],
            [
                'level_id' => $advanced->id,
                'title' => 'System Design Masterclass',
                'slug' => 'system-design-masterclass',
                'description' => 'Learn to design scalable systems. Cover load balancing, caching, database sharding, and high availability patterns.',
                'image_url' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&q=80',
                'is_published' => false,
            ],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(
                ['slug' => $course['slug']],
                $course
            );
        }

        $this->command->info('Created '.count($courses).' courses.');
    }
}
