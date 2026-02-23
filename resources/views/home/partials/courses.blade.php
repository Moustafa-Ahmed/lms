<section id="courses" class="bg-gray-50 py-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-xs font-semibold tracking-widest text-indigo-500 mb-2">COURSES</p>
                <h2 class="text-4xl font-black">Published & ready to watch</h2>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($courses as $course)
                <a href="{{ route('courses.show', $course->slug) }}" class="c-card block group">
                    <div class="overflow-hidden">
                        <img src="{{ $course->image_url ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=70' }}" alt="{{ $course->title }}" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-400">
                    </div>
                    <div class="p-5">
                        <span class="lbadge {{ $course->level->badgeClass() }}">{{ $course->level->name }}</span>
                        <h3 class="font-bold text-sm mt-2 mb-3 leading-snug">{{ $course->title }}</h3>
                        <div class="flex items-center justify-between text-xs text-gray-400">
                            <span>{{ $course->lessonCount() }} lessons · {{ $course->formattedDuration() }}</span>
                            <span class="font-semibold text-indigo-500">Enroll →</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-10 text-gray-500">No published courses available yet.</div>
            @endforelse
        </div>
    </div>
</section>
