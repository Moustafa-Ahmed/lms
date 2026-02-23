<section id="how" class="py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="section-tag justify-center">The Process</div>
            <h2 class="section-heading text-4xl lg:text-5xl">Up and learning in 3 steps</h2>
        </div>
        <div class="steps-grid">
            <div class="steps-connector"></div>
            @foreach ([['Register free', 'Create your account in under 60 seconds. No credit card required.'], ['Pick your path', 'Browse by topic or level. Free previews let you try before enrolling.'], ['Ship & grow', 'Complete lessons, track progress, earn certificates, and get hired.']] as $i => [$title, $desc])
                <div class="step-item" data-step="{{ $i + 1 }}">
                    <div class="step-number">Step 0{{ $i + 1 }}</div>
                    <h3 class="step-title">{{ $title }}</h3>
                    <p class="step-desc">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
