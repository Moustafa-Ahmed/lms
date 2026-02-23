<?php

namespace App\Actions\Course;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class EnrollInCourseAction
{
    public function __invoke(User $user, Course $course): Enrollment
    {
        if (! $course->is_published) {
            throw new \InvalidArgumentException('Cannot enroll in unpublished course.');
        }

        return DB::transaction(function () use ($user, $course) {
            try {
                return Enrollment::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                ]);
            } catch (QueryException $e) {
                if (str_contains($e->getMessage(), 'enrollments_user_id_course_id_unique')) {
                    return Enrollment::query()
                        ->where('user_id', $user->id)
                        ->where('course_id', $course->id)
                        ->firstOrFail();
                }

                throw $e;
            }
        });
    }
}
