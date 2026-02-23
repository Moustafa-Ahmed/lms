<?php

namespace App\Livewire\Courses;

use App\Actions\Course\GetPublishedCoursesAction;
use App\Models\Course;
use Livewire\Component;

class CourseCatalog extends Component
{
    public int $perPage = 6;

    public ?int $totalCount = null;

    public function loadMore(): void
    {
        $this->perPage += 6;
    }

    public function render(GetPublishedCoursesAction $action)
    {
        $courses = $action($this->perPage);

        $this->totalCount ??= Course::query()
            ->where('is_published', true)
            ->count();

        return view('livewire.courses.course-catalog', [
            'courses' => $courses,
            'totalCount' => $this->totalCount,
        ]);
    }
}
