<?php

namespace App\Http\Controllers;

use App\Actions\Lesson\CompleteLessonAction;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LessonCompletionController extends Controller
{
    public function store(
        Request $request,
        Course $course,
        Lesson $lesson,
        CompleteLessonAction $action,
    ): RedirectResponse {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $this->authorize('complete', $lesson);

        $result = $action($request->user(), $lesson, $course);

        if ($result['nextLesson'] !== null) {
            return redirect()
                ->route('lessons.show', [$course->slug, $result['nextLesson']->id])
                ->with('success', 'Lesson completed!');
        }

        return redirect()
            ->route('lessons.show', [$course->slug, $lesson->id])
            ->with('success', $result['courseJustCompleted'] ? 'Congratulations! You completed the course!' : 'Lesson completed!');
    }
}
