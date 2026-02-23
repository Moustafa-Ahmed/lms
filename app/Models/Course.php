<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'level_id',
        'title',
        'slug',
        'description',
        'image_url',
        'is_published',
        'lessons_count',
        'total_duration_seconds',
    ];

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

    public function recalculateStats(): void
    {
        $this->update([
            'lessons_count' => $this->lessons()->count(),
            'total_duration_seconds' => $this->lessons()->sum('duration_seconds'),
        ]);
    }
}
