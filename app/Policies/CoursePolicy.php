<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function enroll(User $user, Course $course): bool
    {
        return $course->is_published;
    }
}
