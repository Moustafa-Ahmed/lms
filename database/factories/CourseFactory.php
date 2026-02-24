<?php

namespace Database\Factories;

use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        $level = Level::inRandomOrder()->first() ?? Level::factory()->create();

        return [
            'level_id' => $level->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(),
            'is_published' => false,
            'lessons_count' => 0,
            'total_duration_seconds' => 0,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }

    public function forLevel(Level $level): static
    {
        return $this->state(fn (array $attributes) => [
            'level_id' => $level->id,
        ]);
    }

    public function withTitle(string $title): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => $title,
            'slug' => Str::slug($title),
        ]);
    }
}
