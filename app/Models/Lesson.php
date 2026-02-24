<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lesson extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\LessonFactory> */
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'course_id',
        'title',
        'order',
        'duration_seconds',
        'is_free_preview',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('lesson_video')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes(['video/mp4', 'video/webm', 'video/ogg', 'video/quicktime']);

        $this->addMediaCollection('lesson_thumbnail')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function getVideoUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('lesson_video');
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('lesson_thumbnail');
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'is_free_preview' => 'boolean',
        ];
    }

    /** @return BelongsTo<Course, $this> */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /** @return HasMany<LessonProgress, $this> */
    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }
}
