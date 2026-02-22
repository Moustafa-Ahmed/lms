<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $learner = User::where('email', 'learner@example.com')->first();

        if (! $learner) {
            $this->command->error('Please run UserSeeder first.');

            return;
        }

        $courses = Course::where('is_published', true)->get();

        if ($courses->isEmpty()) {
            $this->command->error('Please run CourseSeeder first.');

            return;
        }

        $coursesToEnroll = $courses->take(4);

        foreach ($coursesToEnroll as $course) {
            Enrollment::firstOrCreate(
                [
                    'user_id' => $learner->id,
                    'course_id' => $course->id,
                ]
            );
        }

        $this->command->info('Enrolled learner in '.$coursesToEnroll->count().' courses.');
    }
}
