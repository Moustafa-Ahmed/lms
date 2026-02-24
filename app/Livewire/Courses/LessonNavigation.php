<?php

namespace App\Livewire\Courses;

use App\Actions\Lesson\CompleteLessonAction;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class LessonNavigation extends Component
{
    #[Locked]
    public Course $course;

    #[Locked]
    public ?Lesson $currentLesson;

    #[Locked]
    public ?Lesson $previousLesson;

    #[Locked]
    public ?Lesson $nextLesson;

    public bool $isCompleted = false;

    public string $successMessage = '';

    public function complete(CompleteLessonAction $action): void
    {
        $user = Auth::user();

        $this->authorize('complete', $this->currentLesson);

        $result = $action($user, $this->currentLesson, $this->course);

        $this->isCompleted = true;
        $this->nextLesson = $result['nextLesson'];

        $this->successMessage = $result['courseJustCompleted']
            ? 'Congratulations! You have completed the course!'
            : 'Lesson marked as complete!';

        $this->dispatch('lesson-completed',
            lessonId: $this->currentLesson->id,
            courseJustCompleted: $result['courseJustCompleted'],
        );
    }

    public function render(): View
    {
        return view('livewire.courses.lesson-navigation');
    }
}
