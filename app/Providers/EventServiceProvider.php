<?php

namespace App\Providers;

use App\Actions\Fortify\QueueWelcomeEmailAction;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
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
    public function boot(QueueWelcomeEmailAction $queueWelcomeEmail): void
    {
        Event::listen(
            Registered::class,
            function (Registered $event) use ($queueWelcomeEmail): void {
                $queueWelcomeEmail($event->user);
            }
        );
    }
}
