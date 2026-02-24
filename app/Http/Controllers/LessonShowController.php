<?php

namespace App\Http\Controllers;

use App\Actions\Lesson\ShowLessonAction;
use App\Exceptions\EnrollmentRequiredException;
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

        try {
            $result = $action($course, $lesson, Auth::user());
        } catch (EnrollmentRequiredException $e) {
            return redirect()->route('courses.show', $e->course->slug)
                ->with('enrollment_required', true);
        }

        return view('lessons.show', $result);
    }
}
