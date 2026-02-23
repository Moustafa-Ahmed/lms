<section class="hero-gradient">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="lbadge {{ $course->level->badgeClass() }}">{{ $course->level->name }}</span>
                    <span class="text-xs text-gray-400">{{ $course->lessonCount() }} lessons · {{ $course->formattedDuration() }}</span>
                </div>
                <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight mb-4">
                    {{ $course->title }}
                </h1>
                <p class="text-gray-500 text-lg leading-relaxed mb-8">
                    {{ $course->description }}
                </p>

                <livewire:courses.enroll-button :course="$course" />

                @if(session('status'))
                    <div class="mt-4 p-3 bg-green-50 text-green-700 text-sm rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif
            </div>

            <div class="rounded-2xl overflow-hidden shadow-xl border border-gray-200">
                <img src="{{ $course->image_url ?? 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&q=70' }}"
                    alt="{{ $course->title }}"
                    class="w-full h-64 object-cover">
            </div>
        </div>
    </div>
</section>
