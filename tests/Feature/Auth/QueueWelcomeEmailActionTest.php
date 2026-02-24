<?php

use App\Actions\Fortify\QueueWelcomeEmailAction;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('queue welcome email action is idempotent', function () {
    Mail::fake();

    $user = User::factory()->create([
        'welcome_email_sent_at' => null,
    ]);

    $action = app(QueueWelcomeEmailAction::class);

    $action($user);
    $action($user->fresh());

    Mail::assertQueuedCount(1);
    Mail::assertQueued(WelcomeMail::class, function (WelcomeMail $mail) use ($user): bool {
        return $mail->hasTo($user->email);
    });

    expect($user->fresh()->welcome_email_sent_at)->not->toBeNull();
});

test('queue welcome email action does not queue when already marked as sent', function () {
    Mail::fake();

    $user = User::factory()->create([
        'welcome_email_sent_at' => now()->subMinute(),
    ]);

    $action = app(QueueWelcomeEmailAction::class);

    $action($user);

    Mail::assertNothingQueued();
});
