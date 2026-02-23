<?php

namespace Database\Factories;

use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Level>
 */
class LevelFactory extends Factory
{
    protected $model = Level::class;

    public function definition(): array
    {
        return [
            'name' => 'Beginner',
        ];
    }

    public function beginner(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Beginner',
        ]);
    }

    public function intermediate(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Intermediate',
        ]);
    }

    public function advanced(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Advanced',
        ]);
    }

    public function withName(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $name,
        ]);
    }
}
