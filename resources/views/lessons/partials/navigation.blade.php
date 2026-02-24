<div x-data="{
    showCompleteModal: false,
    showEnrollModal: false,
}">
    <div class="lesson-nav">
        <div class="lesson-nav-prev">
            @if ($previousLesson)
                <a href="{{ route('lessons.show', [$course->slug, $previousLesson->id]) }}" class="lesson-nav-link group">
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <div>
                        <div class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Previous</div>
                        <div class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">
                            {{ $previousLesson->title }}</div>
                    </div>
                </a>
            @endif
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('courses.show', $course->slug) }}" class="lesson-nav-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                <span class="hidden sm:inline">Course Home</span>
            </a>
            @auth
                @if (\Illuminate\Support\Facades\Gate::allows('complete', $currentLesson))
                    <form x-ref="completeForm" action="{{ route('lessons.complete', [$course->slug, $currentLesson->id]) }}"
                        method="POST">
                        @csrf
                        <button type="button" @click="showCompleteModal = true" class="lesson-nav-btn-complete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span>Mark Complete</span>
                        </button>
                    </form>
                @endif
            @endauth
        </div>

        <div class="lesson-nav-next">
            @if ($nextLesson)
                @if ($nextLesson->is_free_preview)
                    <a href="{{ route('lessons.show', [$course->slug, $nextLesson->id]) }}"
                        class="lesson-nav-link group justify-end">
                        <div class="text-right">
                            <div class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Next</div>
                            <div class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">
                                {{ $nextLesson->title }}</div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                @elseif(auth()->check() &&
                        $course->enrollments()->where('user_id', auth()->id())->exists())
                    <a href="{{ route('lessons.show', [$course->slug, $nextLesson->id]) }}"
                        class="lesson-nav-link group justify-end">
                        <div class="text-right">
                            <div class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Next</div>
                            <div class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">
                                {{ $nextLesson->title }}</div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                @else
                    <button type="button" @click="showEnrollModal = true" class="lesson-nav-enroll group">
                        <div class="text-right">
                            <div class="text-[10px] uppercase tracking-wider font-semibold opacity-70">Next Lesson</div>
                            <div class="text-sm font-medium">Enroll to Continue</div>
                        </div>
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                @endif
            @endif
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="showCompleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div x-show="showCompleteModal" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 backdrop-blur-sm"
                    @click="showCompleteModal = false"></div>

                <div x-show="showCompleteModal" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 z-10">
                    <div class="text-center">
                        <div class="mx-auto w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2">Mark Lesson Complete?</h3>
                        <p class="text-sm text-gray-500 mb-6">
                            This will update your progress and move you to the next lesson.
                        </p>
                        <div class="flex gap-3">
                            <button type="button" @click="showCompleteModal = false"
                                class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button type="button" @click="$refs.completeForm.submit()"
                                class="flex-1 px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors">
                                Complete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="showEnrollModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div x-show="showEnrollModal" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 backdrop-blur-sm"
                    @click="showEnrollModal = false"></div>

                <div x-show="showEnrollModal" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 z-10">
                    <div class="text-center">
                        <div class="mx-auto w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2">Enroll to Continue</h3>
                        <p class="text-sm text-gray-500 mb-6">
                            You need to enroll in this course to continue watching.
                        </p>
                        <div class="flex flex-col gap-3">
                            @auth
                                <form action="{{ route('courses.enroll', $course->slug) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-teal-600 text-white rounded-lg text-sm font-semibold hover:bg-teal-700 transition-colors">
                                        Enroll Now
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('register') }}"
                                    class="block w-full px-4 py-2 bg-teal-600 text-white rounded-lg text-sm font-semibold text-center hover:bg-teal-700 transition-colors">
                                    Register to Enroll
                                </a>
                                <a href="{{ route('login') }}"
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">
                                    Already have an account? Log in
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
