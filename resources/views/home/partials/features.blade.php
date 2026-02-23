<section id="features" class="max-w-6xl mx-auto px-6 py-20">
    <div class="text-center mb-14">
        <p class="text-xs font-semibold tracking-widest text-indigo-500 mb-3">FEATURES</p>
        <h2 class="text-4xl font-black">Everything you need to level up</h2>
        <p class="text-gray-500 mt-3 max-w-lg mx-auto">Built from the ground up to make learning effective, enjoyable, and measurable.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ([
            ['🎬', 'HD Screencasts', 'Cinematic-quality code walkthroughs. See exactly how real developers think.'],
            ['🗺️', 'Structured Paths', 'Curated learning sequences from beginner to advanced — no guessing what\'s next.'],
            ['📈', 'Progress Tracking', 'Pick up exactly where you left off. Track lesson completions and course progress.'],
            ['🏅', 'Certificates', 'Earn a verified certificate when you complete a course. Share it on LinkedIn.'],
            ['🔓', 'Free Previews', 'Every course has free preview lessons. Try before you commit.'],
            ['⚡', 'Fast & Focused', 'No padding, no filler. Every lesson has a purpose. Respect your time.']
        ] as [$icon, $title, $desc])
            <div class="feat-card">
                <div class="feat-icon">{{ $icon }}</div>
                <h3 class="font-bold text-base mb-2">{{ $title }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</section>
