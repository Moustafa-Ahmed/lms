<?php

namespace App\Livewire\Courses;

use App\Actions\Course\EnrollInCourseAction;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EnrollButton extends Component
{
    public Course $course;

    public bool $isEnrolled = false;

    public function mount(Course $course, bool $isEnrolled = false): void
    {
        $this->course = $course;
        $this->isEnrolled = $isEnrolled;

        if (! $this->isEnrolled && Auth::check()) {
            $this->isEnrolled = Auth::user()->isEnrolledIn($course);
        }
    }

    public function enroll(EnrollInCourseAction $action): void
    {
        if (! Auth::check()) {
            $this->redirect(route('login'));

            return;
        }

        $action(Auth::user(), $this->course);

        $this->isEnrolled = true;
        $this->dispatch('enrolled', courseId: $this->course->id);
    }

    public function render()
    {
        return view('livewire.courses.enroll-button');
    }
}
