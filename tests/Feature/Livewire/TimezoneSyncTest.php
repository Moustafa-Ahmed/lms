<?php

use App\Livewire\TimezoneSync;
use App\Models\User;
use Livewire\Livewire;

test('timezone sync stores utc when client sends invalid timezone', function () {
    $user = User::factory()->create([
        'timezone' => 'UTC',
    ]);

    $this->actingAs($user);

    Livewire::test(TimezoneSync::class)
        ->call('updateUserTimezone', 'Invalid/Timezone');

    expect(session('userTimezone'))->toBe('UTC');
    expect($user->refresh()->timezone)->toBe('UTC');
});

test('timezone sync stores valid timezone in session and user profile', function () {
    $user = User::factory()->create([
        'timezone' => 'UTC',
    ]);

    $this->actingAs($user);

    Livewire::test(TimezoneSync::class)
        ->call('updateUserTimezone', 'America/New_York');

    expect(session('userTimezone'))->toBe('America/New_York');
    expect($user->refresh()->timezone)->toBe('America/New_York');
});

test('timezone sync stores timezone in session for guests', function () {
    Livewire::test(TimezoneSync::class)
        ->call('updateUserTimezone', 'Asia/Kolkata');

    expect(session('userTimezone'))->toBe('Asia/Kolkata');
});
