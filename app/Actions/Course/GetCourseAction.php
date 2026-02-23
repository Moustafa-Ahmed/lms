<?php

namespace App\Actions\Course;

use App\Models\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetCourseAction
{
    public function __invoke(string $slug): Course
    {
        $course = Course::query()
            ->with(['level', 'lessons'])
            ->where('slug', $slug)
            ->first();

        if (! $course || ! $course->is_published) {
            throw new ModelNotFoundException('Course not found.');
        }

        return $course;
    }
}
