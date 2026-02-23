<section class="hero-section">
    {{-- Animated gradient mesh --}}
    <div class="hero-mesh">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-orb hero-orb-3"></div>
        <div class="hero-dot-grid"></div>
        <div class="hero-svg-decoration" aria-hidden="true"></div>
    </div>

    <div
        class="relative z-10 max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-28 grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
        {{-- Left: Copy --}}
        <div>
            <div class="fade-up fade-up-d1">
                <div
                    class="inline-flex items-center gap-2.5 bg-white/70 backdrop-blur-sm text-indigo-600 text-xs font-bold px-4 py-2 rounded-full mb-8 border border-indigo-100/60 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    {{ $totalCourses }} courses live now
                </div>
            </div>

            <h1 class="hero-heading fade-up fade-up-d2">
                The developer<br>
                <span class="hero-gradient-text">learning platform</span><br>
                built to ship.
            </h1>

            <p class="hero-desc mt-6 mb-10 fade-up fade-up-d3">
                Structured courses, HD screencasts, and progress tracking — everything you need to go from curious to
                confident.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 mb-12 fade-up fade-up-d4">
                <a href="{{ route('register') }}" class="btn-indigo px-8 py-4 text-base text-center">
                    <span>Start learning free →</span>
                </a>
                <a href="#courses" class="btn-ghost px-8 py-4 text-base text-center">
                    Browse courses
                </a>
            </div>

            <div class="social-proof fade-up fade-up-d5">
                <div class="avatar-stack">
                    @foreach ([['bg-violet-100 text-violet-600', '👩‍💻'], ['bg-sky-100 text-sky-600', '👨‍💻'], ['bg-emerald-100 text-emerald-600', '🧑‍💻'], ['bg-rose-100 text-rose-600', '👩‍🎓'], ['bg-amber-100 text-amber-600', '👨‍🎓']] as [$colors, $emoji])
                        <div class="avatar-stack-item {{ $colors }}">{{ $emoji }}</div>
                    @endforeach
                </div>
                <div>
                    <div class="flex items-center gap-1.5 text-sm">
                        <span class="star-rating">★★★★★</span>
                        <span class="font-bold text-white">4.9</span>
                    </div>
                    <div class="text-xs text-white/60 mt-0.5">from 2,400+ learners</div>
                </div>
            </div>
        </div>

        {{-- Right: Course player visual --}}
        <div class="fade-up fade-up-d3">
            <div class="hero-visual">

                {{-- Player card --}}
                <div class="hero-player-card">
                    <div class="hero-player-thumb">
                        <div class="hero-play-btn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
                                <path d="M5 3l14 9-14 9V3z" />
                            </svg>
                        </div>
                        <span class="hero-player-time">14:32</span>
                    </div>
                    <div class="hero-player-body">
                        <div class="hero-player-tag">Laravel</div>
                        <div class="hero-player-title">Building REST APIs with Laravel &amp; Sanctum</div>
                        <div class="hero-player-progress-wrap">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs text-slate-400 font-medium">Your progress</span>
                                <span class="text-xs font-bold text-indigo-600">68%</span>
                            </div>
                            <div class="hero-progress-bar">
                                <div class="hero-progress-fill" style="width: 68%"></div>
                            </div>
                        </div>
                        <div class="hero-lesson-list">
                            @foreach ([[true, '1', 'Setting up the project'], [true, '2', 'Auth with Sanctum'], [true, '3', 'Resource controllers'], [false, '4', 'Testing your API'], [false, '5', 'Deployment & CI/CD']] as [$done, $num, $label])
                                <div class="hero-lesson-item {{ $done ? 'hero-lesson-done' : '' }}">
                                    <div class="hero-lesson-check">
                                        @if ($done)
                                            <svg width="10" height="10" viewBox="0 0 12 12" fill="none">
                                                <path d="M2 6l3 3 5-5" stroke="white" stroke-width="1.8"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        @else
                                            <span
                                                class="text-[9px] text-slate-400 font-bold leading-none">{{ $num }}</span>
                                        @endif
                                    </div>
                                    <span>{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
