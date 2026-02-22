<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        $learner = User::firstOrCreate(
            ['email' => 'learner@example.com'],
            [
                'name' => 'Learner User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'is_admin' => false,
            ]
        );

        $this->command->info('Created 2 users: admin@example.com, learner@example.com');
    }
}
