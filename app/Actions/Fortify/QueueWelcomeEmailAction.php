<?php

namespace App\Actions\Fortify;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class QueueWelcomeEmailAction
{
    public function __invoke(User $user): void
    {
        $welcomeEmailQueuedAt = now();

        DB::transaction(function () use ($user, $welcomeEmailQueuedAt): void {
            $currentUser = User::query()
                ->whereKey($user->getKey())
                ->lockForUpdate()
                ->first();

            if ($currentUser === null || $currentUser->welcome_email_sent_at !== null) {
                return;
            }

            $currentUser->forceFill([
                'welcome_email_sent_at' => $welcomeEmailQueuedAt,
            ])->save();

            DB::afterCommit(function () use ($currentUser, $welcomeEmailQueuedAt): void {
                try {
                    Mail::to($currentUser)->queue(new WelcomeMail($currentUser));
                } catch (Throwable $exception) {
                    User::query()
                        ->whereKey($currentUser->getKey())
                        ->where('welcome_email_sent_at', $welcomeEmailQueuedAt)
                        ->update(['welcome_email_sent_at' => null]);

                    throw $exception;
                }
            });
        });
    }
}
