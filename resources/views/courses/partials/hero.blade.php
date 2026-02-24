<section class="hero-gradient">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="lbadge {{ $course->level->badgeClass() }}">{{ $course->level->name }}</span>
                    <span class="text-xs text-gray-400">{{ $course->lessonCount() }} lessons ·
                        {{ $course->formattedDuration() }}</span>
                </div>
                <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight mb-4">
                    {{ $course->title }}
                </h1>
                <p class="text-gray-500 text-lg leading-relaxed mb-8">
                    {{ $course->description }}
                </p>

                <livewire:courses.enroll-button :course="$course" />

                @if (session('enrollment_required'))
                    <div class="mt-4 p-3 bg-amber-50 text-amber-700 text-sm rounded-lg">
                        You need to enroll in this course to view that lesson.
                    </div>
                @endif
            </div>

            <div class="rounded-2xl overflow-hidden shadow-xl border border-gray-200">
                <img src="{{ $course->image_url ?: asset('images/placeholder.jpg') }}" alt="{{ $course->title }}"
                    width="800" height="256" fetchpriority="high" decoding="async"
                    class="w-full h-64 object-cover">
            </div>
        </div>
    </div>
</section>
