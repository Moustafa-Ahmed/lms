<?php

namespace App\Actions\Fortify;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class QueueWelcomeEmailAction
{
    public function __invoke(User $user): void
    {
        $affected = DB::table('users')
            ->where('id', $user->id)
            ->whereNull('welcome_email_sent_at')
            ->update(['welcome_email_sent_at' => now()]);

        if ($affected === 1) {
            Mail::to($user)->send(new WelcomeMail($user));
        }
    }
}
