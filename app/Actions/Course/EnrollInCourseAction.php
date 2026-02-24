<?php

namespace App\Actions\Course;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;

class EnrollInCourseAction
{
    public function __invoke(User $user, Course $course): Enrollment
    {
        if (! $course->is_published) {
            throw new \InvalidArgumentException('Cannot enroll in unpublished course.');
        }

        try {
            return Enrollment::query()->create([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);
        } catch (UniqueConstraintViolationException $exception) {
            return Enrollment::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->firstOrFail();
        }
    }
}
