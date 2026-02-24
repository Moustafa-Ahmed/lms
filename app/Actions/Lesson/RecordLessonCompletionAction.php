<?php

namespace App\Actions\Lesson;

use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;

class RecordLessonCompletionAction
{
    public function __invoke(User $user, Lesson $lesson): LessonProgress
    {
        $progress = LessonProgress::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'started_at' => now(),
                'watch_seconds' => 0,
            ]
        );

        if ($progress->completed_at === null) {
            $progress->update([
                'completed_at' => now(),
                'watch_seconds' => $lesson->duration_seconds ?? $progress->watch_seconds,
            ]);
        }

        return $progress->fresh();
    }
}
