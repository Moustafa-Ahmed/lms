<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Level>
 */
class LevelFactory extends Factory
{
    public function definition(): array
    {
        $names = ['Beginner', 'Intermediate', 'Advanced'];

        return [
            'name' => fake()->randomElement($names),
        ];
    }

    public function beginner(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Beginner',
        ]);
    }

    public function intermediate(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Intermediate',
        ]);
    }

    public function advanced(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Advanced',
        ]);
    }

    public function withName(string $name): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => $name,
        ]);
    }
}
