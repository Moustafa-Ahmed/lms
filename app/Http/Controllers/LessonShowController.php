<?php

namespace App\Http\Controllers;

use App\Actions\Lesson\ShowLessonAction;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LessonShowController extends Controller
{
    public function show(Course $course, Lesson $lesson, ShowLessonAction $action): View|RedirectResponse
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        if (! $lesson->is_free_preview && ! Auth::check()) {
            return redirect()->route('login');
        }

        $this->authorize('view', $lesson);

        $result = $action($course, $lesson, Auth::user());

        return view('lessons.show', $result);
    }
}
