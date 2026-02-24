<?php

namespace App\Livewire\Courses;

use App\Models\Lesson;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class LessonPlayer extends Component
{
    public Lesson $lesson;

    #[Url]
    public bool $autoplay = false;

    public function render(): View
    {
        return view('livewire.courses.lesson-player');
    }
}
