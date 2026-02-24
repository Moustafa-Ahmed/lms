<div class="lesson-sidebar flex flex-col h-full">
    {{-- Course header --}}
    <div class="p-5 border-b border-gray-100/80 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="sidebar-course-icon">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-gray-900 text-sm truncate font-heading">
                    {{ $course->title }}</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ $course->lessons->count() }} lessons</p>
            </div>
        </div>
        @auth
            @if ($isEnrolled && $progressPercentage > 0)
                <div class="mt-4">
                    <div class="flex items-center justify-between text-xs mb-1.5">
                        <span class="text-gray-400 font-medium">Progress</span>
                        <span class="font-bold text-indigo-500">{{ $progressPercentage }}%</span>
                    </div>
                    <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full lesson-progress-fill rounded-full" style="width: {{ $progressPercentage }}%">
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>

    {{-- Lesson list --}}
    <div class="flex-1 overflow-y-auto">
        <div class="p-3 pt-4">
            <h4 class="sidebar-section-label">Course Content</h4>
            @foreach ($course->lessons->sortBy('order') as $index => $sidebarLesson)
                @php
                    $canAccess = $sidebarLesson->is_free_preview || ($isEnrolled && auth()->check());
                    $isCurrent = $sidebarLesson->id === $currentLesson->id;
                    $isLessonCompleted = isset($completedLessons[$sidebarLesson->id]);
                @endphp
                <div wire:key="sidebar-lesson-{{ $sidebarLesson->id }}"
                    class="sidebar-lesson {{ $isCurrent ? 'sidebar-lesson-current' : '' }} mb-0.5">
                    @if ($canAccess)
                        <a href="{{ route('lessons.show', [$course->slug, $sidebarLesson->id]) }}"
                            class="sidebar-lesson-link group">
                            <div class="flex-shrink-0 mt-0.5">
                                @if ($isLessonCompleted)
                                    <div class="sidebar-num sidebar-num-done">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div
                                        class="sidebar-num {{ $isCurrent ? 'sidebar-num-active' : 'sidebar-num-default group-hover:bg-indigo-50 group-hover:text-indigo-500' }}">
                                        {{ $index + 1 }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <span
                                    class="text-[13px] font-medium leading-snug {{ $isCurrent ? 'text-indigo-600' : 'text-gray-600 group-hover:text-gray-900' }} {{ $isLessonCompleted ? 'line-through opacity-50' : '' }} block truncate transition-colors">
                                    {{ $sidebarLesson->title }}
                                </span>
                                <div class="flex items-center gap-2 mt-0.5">
                                    @if ($sidebarLesson->is_free_preview)
                                        <span class="sidebar-free-tag">FREE</span>
                                    @endif
                                    @if ($sidebarLesson->duration_seconds)
                                        <span
                                            class="text-[11px] text-gray-400">{{ floor($sidebarLesson->duration_seconds / 60) }}m</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @else
                        <div class="sidebar-lesson-link opacity-40">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="sidebar-num sidebar-num-locked">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span
                                    class="text-[13px] font-medium text-gray-400 truncate block">{{ $sidebarLesson->title }}</span>
                                @if ($sidebarLesson->duration_seconds)
                                    <span
                                        class="text-[11px] text-gray-300">{{ floor($sidebarLesson->duration_seconds / 60) }}m</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- Footer CTA --}}
    <div class="flex-shrink-0 border-t border-gray-100/80">
        @auth
            @if (!$isEnrolled)
                <div class="p-4">
                    <p class="text-xs text-gray-400 text-center mb-3">Unlock all {{ $course->lessons->count() }} lessons
                    </p>
                    <a href="{{ route('courses.show', $course->slug) }}"
                        class="btn-indigo flex items-center justify-center gap-2 w-full py-2.5 px-4 text-sm">
                        <span>Enroll Now</span>
                    </a>
                </div>
            @endif
        @else
            <div class="p-4">
                <p class="text-xs text-gray-400 text-center mb-3">Sign up to track progress</p>
                <a href="{{ route('register') }}"
                    class="btn-indigo flex items-center justify-center gap-2 w-full py-2.5 px-4 text-sm mb-2">
                    <span>Register Free</span>
                </a>
                <a href="{{ route('login') }}"
                    class="flex items-center justify-center w-full py-2 text-xs font-medium text-gray-400 hover:text-gray-600 transition-colors">
                    Already have an account? Log In
                </a>
            </div>
        @endauth
    </div>
</div>
