<?php

use App\Actions\Fortify\QueueWelcomeEmailAction;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('registration queues welcome email', function () {
    Mail::fake();

    $this->post(route('register.store'), [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    Mail::assertQueued(WelcomeMail::class, function ($mail) {
        return $mail->hasTo('jane@example.com');
    });
});

test('registration sets welcome_email_sent_at on the user', function () {
    Mail::fake();

    $this->post(route('register.store'), [
        'name' => 'Jane Doe',
        'email' => 'jane2@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $user = \App\Models\User::where('email', 'jane2@example.com')->first();
    expect($user->welcome_email_sent_at)->not->toBeNull();
});

test('welcome email timestamp is not written when dispatch fails and can be retried', function () {
    $user = User::factory()->create([
        'welcome_email_sent_at' => null,
    ]);

    $action = app(QueueWelcomeEmailAction::class);

    Mail::shouldReceive('to->queue')->once()->andThrow(new \RuntimeException('Queue transport unavailable'));
    Mail::shouldReceive('to->queue')->once()->andReturnNull();

    expect(fn () => $action($user))->toThrow(\RuntimeException::class);

    $user->refresh();
    expect($user->welcome_email_sent_at)->toBeNull();

    $action($user->fresh());

    $user->refresh();

    expect($user->welcome_email_sent_at)->not->toBeNull();
});

test('registration still succeeds when welcome email dispatch fails', function () {
    Mail::shouldReceive('to->queue')->once()->andThrow(new \RuntimeException('Queue transport unavailable'));

    $response = $this->post(route('register.store'), [
        'name' => 'Retry Safe',
        'email' => 'retry-safe@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $user = User::query()->where('email', 'retry-safe@example.com')->first();

    expect($user)->not->toBeNull();
    expect($user?->welcome_email_sent_at)->toBeNull();
});

test('welcome email is not queued when timestamp already exists', function () {
    Mail::fake();

    $user = User::factory()->create([
        'welcome_email_sent_at' => now(),
    ]);

    app(QueueWelcomeEmailAction::class)($user);

    Mail::assertNothingQueued();
});
