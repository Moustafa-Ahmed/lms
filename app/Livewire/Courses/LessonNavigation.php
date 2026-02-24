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

    #[Locked]
    public bool $isEnrolled = false;

    public bool $canAccessPreviousLesson = false;

    public bool $canAccessNextLesson = false;

    public bool $isCompleted = false;

    public string $successMessage = '';

    public function mount(): void
    {
        $this->syncNavigationAccess();
    }

    public function complete(CompleteLessonAction $action): void
    {
        $user = Auth::user();

        $this->authorize('complete', $this->currentLesson);

        $result = $action($user, $this->currentLesson, $this->course);

        $this->isCompleted = true;
        $this->nextLesson = $result['nextLesson'];
        $this->syncNavigationAccess();

        $this->successMessage = $result['courseJustCompleted']
            ? 'Congratulations! You have completed the course!'
            : 'Lesson marked as complete!';

        $this->dispatch(
            'lesson-completed',
            lessonId: $this->currentLesson->id,
            courseJustCompleted: $result['courseJustCompleted'],
        );
    }

    public function render(): View
    {
        return view('livewire.courses.lesson-navigation');
    }

    private function syncNavigationAccess(): void
    {
        $this->canAccessPreviousLesson = $this->canAccessLesson($this->previousLesson);
        $this->canAccessNextLesson = $this->canAccessLesson($this->nextLesson);
    }

    private function canAccessLesson(?Lesson $lesson): bool
    {
        if ($lesson === null) {
            return false;
        }

        return $lesson->is_free_preview || $this->isEnrolled;
    }
}
