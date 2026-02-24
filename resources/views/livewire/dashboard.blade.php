<div class="max-w-7xl mx-auto px-6 lg:px-8">
    {{-- Enrolled courses --}}
    @if ($enrolledCourses->count() > 0)
        <section class="mb-14">
            <div class="dash-section-header">
                <h2 class="dash-section-title">My Courses</h2>
                <span class="dash-section-count">{{ $enrolledCourses->total() }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($enrolledCourses as $course)
                    @php
                        $totalLessons = $course->lessons->count();
                        $completedCount = $completedLessonsPerCourse->get($course->id, 0);
                        $progress = $totalLessons > 0 ? (int) round(($completedCount / $totalLessons) * 100) : 0;
                        $isCompleted = $completedCourseIds->contains($course->id);
                    @endphp
                    <a href="{{ route('courses.show', $course->slug) }}" class="dash-course-card group"
                        wire:key="enrolled-{{ $course->id }}">
                        <div class="dash-course-img-wrap">
                            <img src="{{ $course->image_url ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=70' }}"
                                alt="{{ $course->title }}" class="dash-course-img" loading="lazy">
                            @if ($isCompleted)
                                <div class="dash-completed-badge">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Completed</span>
                                </div>
                            @elseif($progress > 0)
                                <div class="dash-progress-badge">{{ $progress }}%</div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="lbadge {{ $course->level->badgeClass() }}">{{ $course->level->name }}</span>
                            </div>
                            <h3 class="dash-course-title group-hover:text-indigo-600 transition-colors">
                                {{ $course->title }}</h3>
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-xs text-gray-400 font-medium">{{ $course->lessonCount() }}
                                    lessons &middot; {{ $course->formattedDuration() }}</span>
                            </div>
                            @if ($progress > 0 && !$isCompleted)
                                <div class="mt-3">
                                    <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full lesson-progress-fill rounded-full"
                                            style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            @if ($enrolledCourses->hasPages())
                <div class="mt-8">
                    {{ $enrolledCourses->links() }}
                </div>
            @endif
        </section>
    @else
        <section class="mb-14">
            <div class="dash-empty">
                <div class="dash-empty-icon">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mt-4" style="font-family: var(--heading-font);">No
                    courses yet</h3>
                <p class="text-sm text-gray-400 mt-1">Enroll in a course to start learning</p>
            </div>
        </section>
    @endif

    {{-- Available courses --}}
    @if ($availableCourses->count() > 0)
        <section>
            <div class="dash-section-header">
                <h2 class="dash-section-title">Explore More</h2>
                <span class="dash-section-count">{{ $availableCourses->total() }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($availableCourses as $course)
                    <a href="{{ route('courses.show', $course->slug) }}" class="c-card block group"
                        wire:key="available-{{ $course->id }}">
                        <div class="overflow-hidden">
                            <img src="{{ $course->image_url ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=70' }}"
                                alt="{{ $course->title }}"
                                class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                loading="lazy">
                        </div>
                        <div class="p-6">
                            <span class="lbadge {{ $course->level->badgeClass() }}">{{ $course->level->name }}</span>
                            <h3 class="font-bold text-base mt-3 mb-3 leading-snug text-slate-900"
                                style="font-family: var(--heading-font);">{{ $course->title }}</h3>
                            <div class="flex items-center justify-between text-xs text-slate-400">
                                <span class="font-medium">{{ $course->lessonCount() }} lessons &middot;
                                    {{ $course->formattedDuration() }}</span>
                                <span
                                    class="font-bold text-indigo-500 group-hover:translate-x-1 transition-transform duration-300">Enroll
                                    &rarr;</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            @if ($availableCourses->hasPages())
                <div class="mt-8">
                    {{ $availableCourses->links() }}
                </div>
            @endif
        </section>
    @endif
</div>
