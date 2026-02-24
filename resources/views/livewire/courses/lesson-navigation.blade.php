<div
    x-data="{
        showCompleteModal: false,
        completeForm: null,
    }"
>
    <div class="flex items-center justify-between">
        <div>
            @if($previousLesson)
                <a
                    href="{{ route('lessons.show', [$course->slug, $previousLesson->id]) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition-colors"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <div>
                        <div class="text-xs text-gray-500">Previous</div>
                        <div class="text-sm font-medium">{{ $previousLesson->title }}</div>
                    </div>
                </a>
            @else
                <div></div>
            @endif
        </div>

        <div class="flex items-center gap-3">
            @auth
                @can('complete', $currentLesson)
                    <form
                        x-ref="completeForm"
                        action="{{ route('lessons.complete', [$course->slug, $currentLesson->id]) }}"
                        method="POST"
                    >
                        @csrf
                        <button
                            type="button"
                            @click="showCompleteModal = true"
                            class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-sm font-medium transition-colors"
                        >
                            Mark Complete
                        </button>
                    </form>
                @endcan
            @endauth
        </div>

        <div>
            @if($nextLesson)
                <a
                    href="{{ route('lessons.show', [$course->slug, $nextLesson->id]) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition-colors"
                >
                    <div class="text-right">
                        <div class="text-xs text-gray-500">Next</div>
                        <div class="text-sm font-medium">{{ $nextLesson->title }}</div>
                    </div>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                <div></div>
            @endif
        </div>
    </div>

    <div
        x-show="showCompleteModal"
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
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showCompleteModal = false"></div>

            <div
                x-show="showCompleteModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 z-10"
            >
                <div class="text-center">
                    <div class="mx-auto w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Mark Lesson Complete?</h3>
                    <p class="text-sm text-gray-500 mb-6">
                        This will update your progress and move you to the next lesson.
                    </p>
                    <div class="flex gap-3">
                        <button
                            type="button"
                            @click="showCompleteModal = false"
                            class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            @click="$refs.completeForm.submit()"
                            class="flex-1 px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors"
                        >
                            Complete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
