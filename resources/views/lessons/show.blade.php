@extends('layouts.lesson', [
    'title' => $lesson->title . ' — ' . $course->title . ' — Career 180',
    'description' => 'Watch ' . $lesson->title . ' from ' . $course->title . ' on Career 180.',
])

@section('content')
    <div class="lesson-page min-h-screen pb-12">
        <div class="flex flex-col lg:flex-row">
            {{-- Main content --}}
            <div class="flex-1 min-w-0">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 pt-6 pb-8">
                    {{-- Video card --}}
                    <div class="lesson-card fade-up">
                        {{-- Accent top bar --}}
                        <div class="lesson-card-accent"></div>

                        {{-- Lesson header --}}
                        <div class="lesson-header">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="lesson-counter">
                                    {{ $lesson->order }}<span
                                        class="lesson-counter-sep">/</span>{{ $course->lessons->count() }}
                                </span>
                                @if ($lesson->is_free_preview)
                                    <span class="lesson-preview-tag">Free Preview</span>
                                @endif
                            </div>
                            <h1 class="lesson-title">{{ $lesson->title }}</h1>
                            @if ($lesson->duration_seconds)
                                <div class="lesson-meta">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ floor($lesson->duration_seconds / 60) }} min</span>
                                </div>
                            @endif
                        </div>

                        {{-- Video player --}}
                        <div class="lesson-video-wrap fade-up fade-up-d1">
                            <div class="lesson-video-glow"></div>
                            <div class="aspect-video bg-gray-950 relative rounded-lg overflow-hidden">
                                @include('lessons.partials.player', ['lesson' => $lesson])
                            </div>
                        </div>

                        {{-- Navigation --}}
                        <div class="lesson-nav-wrap fade-up fade-up-d2">
                            <livewire:courses.lesson-navigation
                                :course="$course"
                                :current-lesson="$lesson"
                                :previous-lesson="$previousLesson"
                                :next-lesson="$nextLesson"
                            />
                        </div>
                    </div>

                    @auth
                        @if ($isEnrolled)
                            <div
                                x-data="{ pct: {{ $progressPercentage }} }"
                                @progress-updated.window="pct = $event.detail.percentage"
                                x-show="pct > 0"
                                class="lesson-progress-bar fade-up fade-up-d3"
                            >
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Course
                                        Progress</span>
                                    <span class="text-sm font-bold text-indigo-500" x-text="pct + '%'"></span>
                                </div>
                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full lesson-progress-fill rounded-full" :style="'width: ' + pct + '%'"></div>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="hidden lg:block lg:w-80 xl:w-96 flex-shrink-0 pb-12">
                <div class="sticky top-[72px] h-[calc(100vh-72px)]">
                    <livewire:courses.lesson-sidebar :course="$course" :current-lesson="$lesson" />
                </div>
            </div>
        </div>
    </div>
@endsection
