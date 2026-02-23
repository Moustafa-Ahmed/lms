<?php

namespace App\Livewire\Courses;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class LessonList extends Component
{
    public Course $course;

    public bool $isEnrolled = false;

    public array $completedLessons = [];

    protected $listeners = [
        'enrolled' => 'refreshProgress',
        'lesson-completed' => 'handleLessonCompleted',
    ];

    public function mount(Course $course): void
    {
        $this->course = $course;

        if (Auth::check()) {
            $this->loadUserProgress();
        }
    }

    protected function loadUserProgress(): void
    {
        $userId = Auth::id();
        $lessonIds = $this->course->lessons->pluck('id');

        $this->isEnrolled = Enrollment::query()
            ->where('user_id', $userId)
            ->where('course_id', $this->course->id)
            ->exists();

        if (! $this->isEnrolled) {
            return;
        }

        $this->completedLessons = LessonProgress::query()
            ->where('user_id', $userId)
            ->whereIn('lesson_id', $lessonIds)
            ->whereNotNull('completed_at')
            ->pluck('lesson_id')
            ->map(fn ($id) => (string) $id)
            ->toArray();
    }

    public function refreshProgress(): void
    {
        $this->isEnrolled = true;
        $this->loadUserProgress();
    }

    public function handleLessonCompleted(int $lessonId): void
    {
        $this->completedLessons[] = (string) $lessonId;
    }

    #[Computed]
    public function progressPercentage(): int
    {
        $totalLessons = $this->course->lessons->count();

        if ($totalLessons === 0) {
            return 0;
        }

        return (int) round((count($this->completedLessons) / $totalLessons) * 100);
    }

    #[Computed]
    public function completedCount(): int
    {
        return count($this->completedLessons);
    }

    public function render()
    {
        return view('livewire.courses.lesson-list');
    }
}
