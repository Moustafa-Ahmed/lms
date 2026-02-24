<?php

namespace App\Observers;

use App\Models\Course;

class CourseObserver
{
    /**
     * Handle the Course "created" event.
     */
    public function created(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "updated" event.
     */
    public function updated(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "restoring" event.
     *
     * Prevents restoring a course when its slug is already taken by an active course.
     */
    public function restoring(Course $course): bool
    {
        $exists = Course::query()
            ->where('slug', $course->slug)
            ->where('id', '!=', $course->id)
            ->exists();

        if ($exists) {
            return false;
        }

        return true;
    }

    /**
     * Handle the Course "deleted" event.
     */
    public function deleted(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "restored" event.
     */
    public function restored(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "force deleted" event.
     */
    public function forceDeleted(Course $course): void
    {
        //
    }
}
