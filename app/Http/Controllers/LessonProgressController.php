<?php

namespace App\Http\Controllers;

use App\Actions\Lesson\TrackWatchTimeAction;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LessonProgressController extends Controller
{
    public function update(Request $request, Course $course, Lesson $lesson, TrackWatchTimeAction $action): JsonResponse
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $this->authorize('complete', $lesson);

        $validated = $request->validate([
            'watch_seconds' => ['required', 'integer', 'min:0'],
        ]);

        $progress = $action($request->user(), $lesson, $validated['watch_seconds']);

        return response()->json(['watch_seconds' => $progress->watch_seconds]);
    }
}
