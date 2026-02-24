<?php

namespace App\Http\Controllers;

use App\Actions\Course\EnrollInCourseAction;
use App\Actions\Course\GetCourseAction;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $totalCourses = Course::published()->count();

        $featuredCourse = Course::published()
            ->with(['level', 'lessons' => fn ($q) => $q->orderBy('order')->limit(5)])
            ->first();

        return view('home.index', compact('totalCourses', 'featuredCourse'));
    }

    public function show(string $slug, GetCourseAction $action): View
    {
        $course = $action($slug);

        return view('courses.show', compact('course'));
    }

    public function enroll(Request $request, string $slug, EnrollInCourseAction $action, GetCourseAction $getCourse): RedirectResponse
    {
        $course = $getCourse($slug);

        $this->authorize('enroll', $course);

        $action($request->user(), $course);

        return redirect()->route('courses.show', $course->slug)
            ->with('status', 'Successfully enrolled in the course!');
    }
}
