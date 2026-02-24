<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function view(?User $user, Lesson $lesson): bool
    {
        if ($lesson->is_free_preview) {
            return true;
        }

        if ($user === null) {
            return false;
        }

        return $user->isEnrolledIn($lesson->course);
    }

    public function complete(User $user, Lesson $lesson): bool
    {
        return $user->isEnrolledIn($lesson->course);
    }
}
