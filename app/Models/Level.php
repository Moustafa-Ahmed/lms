<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    /** @use HasFactory<\Database\Factories\LevelFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    /** @return HasMany<Course, $this> */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function badgeClass(): string
    {
        return match ($this->name) {
            'Beginner' => 'lb-beg',
            'Intermediate' => 'lb-mid',
            'Advanced' => 'lb-adv',
            default => 'lb-beg',
        };
    }
}
