<?php

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

    Mail::assertQueued(\App\Mail\WelcomeMail::class, function ($mail) {
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
