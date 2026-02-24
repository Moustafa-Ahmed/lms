<?php

namespace App\Actions\Course;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class GetPublishedCoursesAction
{
    /**
     * @return Collection<int, Course>
     */
    public function __invoke(?int $perPage = null, ?int $skip = null): Collection
    {
        $query = Course::query()
            ->with(['level', 'media'])
            ->where('is_published', true)
            ->latest();

        if ($perPage !== null) {
            $query->take($perPage);
        }

        if ($skip !== null) {
            $query->skip($skip);
        }

        return $query->get();
    }
}
