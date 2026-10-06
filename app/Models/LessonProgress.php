<?php

namespace App\Models;

use Database\Factories\LessonProgressFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class LessonProgress extends Model
{
    /** @use HasFactory<LessonProgressFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lesson_id',
        'watch_seconds',
        'started_at',
        'completed_at',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'watch_seconds' => 'integer',
        ];
    }

    /**
     * @param  Builder<LessonProgress>  $query
     * @param  Collection<int, int>|array<int>  $lessonIds
     */
    public function scopeForLessons(Builder $query, Collection|array $lessonIds): void
    {
        $query->whereIn('lesson_id', $lessonIds);
    }

    /**
     * @param  Builder<LessonProgress>  $query
     * @return Builder<LessonProgress>
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->id);
    }

    /**
     * @param  Builder<LessonProgress>  $query
     * @return Builder<LessonProgress>
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereNotNull('completed_at');
    }

    /**
     * @param  Builder<LessonProgress>  $query
     * @return Builder<LessonProgress>
     */
    public function scopeInProgress(Builder $query): Builder
    {
        return $query->whereNotNull('started_at')->whereNull('completed_at');
    }

    public function isInProgress(): bool
    {
        return $this->started_at !== null && $this->completed_at === null;
    }

    public function isCompleted(): bool
    {
        return $this->completed_at !== null;
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Lesson, $this> */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
