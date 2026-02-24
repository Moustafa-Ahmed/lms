<?php

namespace App\Actions\Course;

use App\Mail\CourseCompletionMail;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendCourseCompletionEmailAction
{
    public function __invoke(User $user, Course $course): void
    {
        Mail::to($user->email)->queue(new CourseCompletionMail($user, $course));
    }
}
