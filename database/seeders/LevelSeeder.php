<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['name' => 'Beginner'],
            ['name' => 'Intermediate'],
            ['name' => 'Advanced'],
        ];

        foreach ($levels as $level) {
            Level::firstOrCreate(
                ['name' => $level['name']],
                $level
            );
        }

        $this->command->info('Created '.count($levels).' levels.');
    }
}
