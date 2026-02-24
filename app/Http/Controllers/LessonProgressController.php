<?php

namespace App\Http\Controllers;

use App\Actions\Lesson\TrackWatchTimeAction;
use App\Http\Requests\TrackLessonProgressRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\JsonResponse;

class LessonProgressController extends Controller
{
    public function update(TrackLessonProgressRequest $request, Course $course, Lesson $lesson, TrackWatchTimeAction $action): JsonResponse
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $this->authorize('complete', $lesson);

        $validated = $request->validated();

        $progress = $action($request->user(), $lesson, $validated['watch_seconds']);

        return response()->json(['watch_seconds' => $progress->watch_seconds]);
    }
}
