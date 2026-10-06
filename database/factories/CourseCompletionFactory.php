<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CourseCompletion>
 */
class CourseCompletionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'completed_at' => now(),
        ];
    }

    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    public function forCourse(Course $course): static
    {
        return $this->state(fn (array $attributes) => [
            'course_id' => $course->id,
        ]);
    }

    public function completedAt(\DateTimeInterface $date): static
    {
        return $this->state(fn (array $attributes) => [
            'completed_at' => $date,
        ]);
    }
}
