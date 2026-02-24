<?php

namespace App\Actions\Lesson;

use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;

class TrackWatchTimeAction
{
    public function __invoke(User $user, Lesson $lesson, int $watchSeconds): LessonProgress
    {
        $progress = LessonProgress::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'watch_seconds' => $watchSeconds,
                'started_at' => now(),
            ]
        );

        if (! $progress->wasRecentlyCreated) {
            $progress->update(['watch_seconds' => max($progress->watch_seconds, $watchSeconds)]);
        }

        return $progress;
    }
}
