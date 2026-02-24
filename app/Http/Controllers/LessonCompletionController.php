<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;

class LessonCompletionController extends Controller
{
    public function store(Course $course, Lesson $lesson): RedirectResponse
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $this->authorize('complete', $lesson);

        return redirect()->route('lessons.show', [$course->slug, $lesson->id])
            ->with('info', 'Lesson completion tracking coming in Phase 4!');
    }
}
