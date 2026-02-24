<?php

namespace App\Exceptions;

use App\Models\Course;
use Exception;

class EnrollmentRequiredException extends Exception
{
    public function __construct(public readonly Course $course)
    {
        parent::__construct('Enrollment is required to access this lesson.');
    }
}
