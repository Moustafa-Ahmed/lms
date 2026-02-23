<div
    x-data="{
        expanded: true,
        showConfirmModal: false,
        pendingLesson: null,
        progress: {{ $this->progressPercentage }},
    }"
>
    @if(auth()->check() && $isEnrolled)
        <div class="mb-6 p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl border border-indigo-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-semibold text-gray-500">Your Progress</span>
                <span class="text-sm font-bold text-indigo-500">
                    <span x-text="progress">{{ $this->progressPercentage }}</span>% Complete
                </span>
            </div>
            <div class="h-3 bg-white rounded-full overflow-hidden shadow-inner">
                <div
                    class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-500 ease-out"
                    :style="'width: ' + progress + '%'"
                    x-init="$nextTick(() => progress = {{ $this->progressPercentage }})"
                ></div>
            </div>
            <div class="mt-2 text-xs text-gray-400">
                {{ $this->completedCount }} of {{ $course->lessons->count() }} lessons completed
            </div>
        </div>
    @endif

    <button
        @click="expanded = !expanded"
        class="w-full flex items-center justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
    >
        <div class="flex items-center gap-3">
            <svg
                class="w-5 h-5 text-indigo-500 transition-transform duration-300"
                :class="{ 'rotate-90': expanded }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <h2 class="text-xl font-bold">Course Content</h2>
        </div>
        <span class="text-sm text-gray-500">{{ $course->lessons->count() }} lessons</span>
    </button>

    <div
        x-show="expanded"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="space-y-2"
    >
        @forelse($course->lessons as $lesson)
            @php
                $isCompleted = in_array((string) $lesson->id, $completedLessons);
                $canAccess = $lesson->is_free_preview || $isEnrolled;
            @endphp
            <div
                wire:key="lesson-{{ $lesson->id }}"
                class="lesson-item {{ $lesson->is_free_preview ? 'preview' : '' }} {{ $isCompleted ? 'completed' : '' }}"
                :class="{ 'ring-2 ring-green-400 bg-green-50': {{ $isCompleted ? 'true' : 'false' }} }"
            >
                <div class="lesson-num {{ $isCompleted ? 'bg-green-500 text-white' : '' }}">
                    @if($isCompleted)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @else
                        {{ $lesson->order }}
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-sm truncate {{ $isCompleted ? 'text-green-700' : '' }}">{{ $lesson->title }}</span>
                        @if($lesson->is_free_preview)
                            <span class="preview-badge">FREE PREVIEW</span>
                        @endif
                    </div>
                    @if($lesson->duration_seconds)
                        <span class="text-xs text-gray-400">
                            {{ floor($lesson->duration_seconds / 60) }} min
                        </span>
                    @endif
                </div>

                @if($canAccess)
                    <a
                        href="{{ route('lessons.show', [$course->slug, $lesson->id]) }}"
                        class="text-indigo-500 text-sm font-semibold hover:underline flex items-center gap-1"
                    >
                        @if($isCompleted)
                            <span>Review</span>
                        @else
                            <span>Watch</span>
                        @endif
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        </svg>
                    </a>
                @else
                    <span class="text-xs text-gray-400" title="Enroll to access">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </span>
                @endif
            </div>
        @empty
            <div class="text-center py-10 text-gray-500">
                No lessons available yet.
            </div>
        @endforelse
    </div>

    <div
        x-show="showConfirmModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showConfirmModal = false"></div>

            <div
                x-show="showConfirmModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 z-10"
            >
                <div class="text-center">
                    <div class="mx-auto w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Mark Lesson Complete?</h3>
                    <p class="text-sm text-gray-500 mb-6">
                        This will update your progress and move you to the next lesson.
                    </p>
                    <div class="flex gap-3">
                        <button
                            @click="showConfirmModal = false"
                            class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors"
                        >
                            Cancel
                        </button>
                        <button
                            @click="confirmComplete()"
                            class="flex-1 px-4 py-2 bg-indigo-500 text-white rounded-lg text-sm font-semibold hover:bg-indigo-600 transition-colors"
                        >
                            Complete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
