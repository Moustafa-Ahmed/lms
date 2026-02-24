<?php

namespace App\Providers;

use App\Actions\Fortify\QueueWelcomeEmailAction;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Throwable;

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
                try {
                    $queueWelcomeEmail($event->user);
                } catch (Throwable $exception) {
                    Log::warning('Welcome email dispatch failed after registration.', [
                        'user_id' => $event->user->id,
                        'exception' => $exception,
                    ]);
                }
            }
        );
    }
}
