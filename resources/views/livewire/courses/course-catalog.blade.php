<div class="course-catalog">
    <div class="flex items-end justify-between mb-10">
        <div>
            <p class="text-xs font-semibold tracking-widest text-indigo-500 mb-2">COURSES</p>
            <h2 class="text-4xl font-black">Published & ready to watch</h2>
        </div>
        <p class="text-sm text-gray-400">
            {{ $courses->count() }} of {{ $totalCount }} courses
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($courses as $course)
            <a
                href="{{ route('courses.show', $course->slug) }}"
                class="c-card block group"
                wire:key="course-{{ $course->id }}"
            >
                <div class="overflow-hidden">
                    <img
                        src="{{ $course->image_url ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=70' }}"
                        alt="{{ $course->title }}"
                        class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-400"
                    >
                </div>
                <div class="p-5">
                    <span class="lbadge {{ $course->level->badgeClass() }}">
                        {{ $course->level->name }}
                    </span>
                    <h3 class="font-bold text-sm mt-2 mb-3 leading-snug">
                        {{ $course->title }}
                    </h3>
                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <span>{{ $course->lessonCount() }} lessons · {{ $course->formattedDuration() }}</span>
                        <span class="font-semibold text-indigo-500">Enroll →</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-10 text-gray-500">
                No published courses available yet.
            </div>
        @endforelse
    </div>

    @if($courses->count() < $totalCount)
        <div class="mt-10 text-center">
            <button
                wire:click="loadMore"
                wire:loading.attr="disabled"
                class="btn-border px-8 py-3 text-sm inline-flex items-center gap-2"
            >
                <span wire:loading.remove>
                    Load {{ min(6, $totalCount - $courses->count()) }} more courses
                </span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Loading...
                </span>
            </button>
        </div>
    @endif
</div>
