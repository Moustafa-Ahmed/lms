<?php

namespace App\Http\Controllers;

use App\Actions\Lesson\GetLessonAction;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LessonShowController extends Controller
{
    public function show(Course $course, Lesson $lesson, GetLessonAction $action): View|RedirectResponse
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        if (! $lesson->is_free_preview && ! Auth::check()) {
            return redirect()->route('login');
        }

        $isEnrolled = false;
        $completedLessons = [];
        $progressPercentage = 0;

        if (Auth::check()) {
            $isEnrolled = Auth::user()->isEnrolledIn($course);

            if (! $isEnrolled && ! $lesson->is_free_preview) {
                return redirect()->route('courses.show', $course->slug)
                    ->with('enrollment_required', true);
            }

            if ($isEnrolled) {
                $completedLessons = LessonProgress::query()
                    ->forUser(Auth::user())
                    ->forLessons($course->lessons->pluck('id'))
                    ->completed()
                    ->pluck('lesson_id', 'lesson_id')
                    ->toArray();

                $totalLessons = $course->lessons->count();
                $progressPercentage = $totalLessons > 0
                    ? (int) round((count($completedLessons) / $totalLessons) * 100)
                    : 0;
            }
        }

        $data = $action($course, $lesson->id);

        return view('lessons.show', [
            'course' => $course,
            'lesson' => $data['lesson'],
            'previousLesson' => $data['previousLesson'],
            'nextLesson' => $data['nextLesson'],
            'isEnrolled' => $isEnrolled,
            'completedLessons' => $completedLessons,
            'progressPercentage' => $progressPercentage,
        ]);
    }
}
