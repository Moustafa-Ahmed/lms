<?php

namespace App\Exceptions;

use App\Models\Course;
use Exception;

class CourseNotPublishedException extends Exception
{
    public function __construct(public readonly Course $course)
    {
        parent::__construct("Course [{$course->slug}] is not published.");
    }
}
