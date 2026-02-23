<section id="how" class="max-w-6xl mx-auto px-6 py-20">
    <div class="text-center mb-14">
        <p class="text-xs font-semibold tracking-widest text-indigo-500 mb-3">THE PROCESS</p>
        <h2 class="text-4xl font-black">Up and learning in 3 steps</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        @foreach ([
            ['Register free', 'Create your account in under 60 seconds. No credit card required.'],
            ['Pick your path', 'Browse by topic or level. Free previews let you try before enrolling.'],
            ['Ship & grow', 'Complete lessons, track progress, earn certificates, and get hired.']
        ] as $i => [$title, $desc])
            <div class="relative">
                <div class="step-num">0{{ $i + 1 }}</div>
                <h3 class="text-xl font-bold mb-2">{{ $title }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</section>
