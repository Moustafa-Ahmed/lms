<?php

namespace App\Livewire\Courses;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\View\View;
use Livewire\Component;

class LessonNavigation extends Component
{
    public Course $course;

    public ?Lesson $currentLesson;

    public ?Lesson $previousLesson;

    public ?Lesson $nextLesson;

    public function render(): View
    {
        return view('livewire.courses.lesson-navigation');
    }
}
