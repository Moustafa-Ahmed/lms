<?php

namespace App\Providers;

use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(
            Registered::class,
            function (Registered $event) {
                if (is_null($event->user->welcome_email_sent_at)) {
                    $event->user->welcome_email_sent_at = now();
                    $event->user->save();
                    Mail::to($event->user)->send(new WelcomeMail($event->user));
                }
            }
        );
    }
}
