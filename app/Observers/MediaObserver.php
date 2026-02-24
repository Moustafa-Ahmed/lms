<?php

namespace App\Observers;

use App\Models\Lesson;
use getID3;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class MediaObserver
{
    public function __construct(private readonly getID3 $getID3) {}

    public function handle(MediaHasBeenAddedEvent $event): void
    {
        $media = $event->media;

        if ($media->collection_name !== 'lesson_video') {
            return;
        }

        $info = $this->getID3->analyze($media->getPath());
        $duration = (int) round((float) ($info['playtime_seconds'] ?? 0));

        if ($duration > 0) {
            $lesson = Lesson::find($media->model_id);
            $lesson?->update(['duration_seconds' => $duration]);
            $lesson?->course?->recalculateStats();
        }
    }
}
