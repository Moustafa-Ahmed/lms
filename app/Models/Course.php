<?php

namespace App\Models;

use App\Observers\CourseObserver;
use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'level_id',
        'title',
        'slug',
        'description',
        'is_published',
        'lessons_count',
        'total_duration_seconds',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('course_image')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('course_image');
    }

    protected static function booted(): void
    {
        static::observe(CourseObserver::class);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'lessons_count' => 'integer',
            'total_duration_seconds' => 'integer',
        ];
    }

    /** @return BelongsTo<Level, $this> */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /** @return HasMany<Lesson, $this> */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    /** @return HasMany<Enrollment, $this> */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /** @return HasMany<CourseCompletion, $this> */
    public function completions(): HasMany
    {
        return $this->hasMany(CourseCompletion::class);
    }

    public function totalDuration(): int
    {
        return $this->total_duration_seconds;
    }

    public function lessonCount(): int
    {
        return $this->lessons_count;
    }

    public function formattedDuration(): string
    {
        $seconds = $this->total_duration_seconds;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        return sprintf('%dh %02dm', $hours, $minutes);
    }

    /** @param Builder<Course> $query */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    /**
     * @param  Builder<Course>  $query
     * @param  Collection<int, int>|array<int>  $courseIds
     */
    public function scopeEnrolledIn(Builder $query, Collection|array $courseIds): void
    {
        $query->whereIn('id', $courseIds);
    }

    /**
     * Appends `is_enrolled` and `is_completed` boolean columns for the given user.
     *
     * @param  Builder<Course>  $query
     */
    public function scopeWithEnrollmentStatusFor(Builder $query, User $user): void
    {
        $query
            ->withExists(['enrollments as is_enrolled' => fn ($q) => $q->where('user_id', $user->id)])
            ->withExists(['completions as is_completed' => fn ($q) => $q->where('user_id', $user->id)]);
    }

    /**
     * Loads `is_enrolled` and `is_completed` onto an already-bound model instance
     * using a single query, so downstream calls to User::isEnrolledIn() and
     * User::hasCompletedCourse() skip the database.
     */
    public function loadEnrollmentStatusFor(User $user): static
    {
        $status = static::query()
            ->select(['id'])
            ->withEnrollmentStatusFor($user)
            ->whereKey($this->getKey())
            ->first();

        $this->setAttribute('is_enrolled', (bool) $status?->is_enrolled);
        $this->setAttribute('is_completed', (bool) $status?->is_completed);

        return $this;
    }

    /**
     * @param  Builder<Course>  $query
     * @param  Collection<int, int>|array<int>  $courseIds
     */
    public function scopeNotEnrolledIn(Builder $query, Collection|array $courseIds): void
    {
        $query->whereNotIn('id', $courseIds);
    }

    public function recalculateStats(): void
    {
        $this->update([
            'lessons_count' => $this->lessons()->count(),
            'total_duration_seconds' => $this->lessons()->sum('duration_seconds'),
        ]);
    }
}
