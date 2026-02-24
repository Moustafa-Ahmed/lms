<?php

namespace App\Livewire\Courses;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class LessonSidebar extends Component
{
    #[Locked]
    public Course $course;

    #[Locked]
    public Lesson $currentLesson;

    public bool $isEnrolled = false;

    /** @var array<int, int> */
    public array $completedLessons = [];

    public int $progressPercentage = 0;

    public function mount(): void
    {
        if (Auth::check()) {
            $this->loadProgress();
        }
    }

    protected function loadProgress(): void
    {
        $user = Auth::user();

        $this->isEnrolled = $user->isEnrolledIn($this->course);

        if (! $this->isEnrolled) {
            return;
        }

        $this->completedLessons = LessonProgress::query()
            ->forUser($user)
            ->forLessons($this->course->lessons->pluck('id'))
            ->completed()
            ->pluck('lesson_id', 'lesson_id')
            ->toArray();

        $this->recalculateProgress();
    }

    protected function recalculateProgress(): void
    {
        $totalLessons = $this->course->lessons->count();
        $this->progressPercentage = $totalLessons > 0
            ? (int) round((count($this->completedLessons) / $totalLessons) * 100)
            : 0;
    }

    #[On('lesson-completed')]
    public function handleLessonCompleted(int $lessonId): void
    {
        $this->completedLessons[$lessonId] = $lessonId;
        $this->recalculateProgress();
        $this->dispatch('progress-updated', percentage: $this->progressPercentage);
    }

    #[On('enrolled')]
    public function handleEnrolled(): void
    {
        $this->loadProgress();
    }

    public function render(): View
    {
        return view('livewire.courses.lesson-sidebar');
    }
}
