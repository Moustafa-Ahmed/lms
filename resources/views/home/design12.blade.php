<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Career 180 — The Developer Learning Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #111827;
        }

        :root {
            --indigo: #6366F1;
            --indigo-dark: #4F46E5;
            --surface: #F9FAFB;
            --border: #E5E7EB;
            --muted: #6B7280;
        }

        .nav-border {
            border-bottom: 1px solid var(--border);
        }

        /* Hero */
        .hero-bg {
            background: radial-gradient(ellipse 80% 60% at 60% 50%, rgba(99, 102, 241, 0.08) 0%, transparent 70%);
        }

        /* Gradient text */
        .gradient-heading {
            background: linear-gradient(135deg, #111827 30%, #6366F1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* CTA */
        .btn-indigo {
            background: var(--indigo);
            color: #fff;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-indigo:hover {
            background: var(--indigo-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
        }

        .btn-border {
            border: 1.5px solid var(--border);
            color: #374151;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-border:hover {
            border-color: var(--indigo);
            color: var(--indigo);
        }

        /* Browser mockup */
        .browser-chrome {
            background: #F3F4F6;
            border-radius: 12px 12px 0 0;
            padding: 10px 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .browser-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .browser-wrap {
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(99, 102, 241, 0.12), 0 4px 16px rgba(0, 0, 0, 0.06);
        }

        /* Course list in mockup */
        .mockup-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .mockup-thumbnail {
            width: 48px;
            height: 36px;
            border-radius: 6px;
            object-fit: cover;
            flex-shrink: 0;
        }

        /* Feature card */
        .feat-card {
            padding: 2rem;
            border: 1px solid var(--border);
            border-radius: 16px;
            transition: all 0.2s;
        }

        .feat-card:hover {
            border-color: var(--indigo);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.06);
        }

        .feat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: rgba(99, 102, 241, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        /* Steps */
        .step-num {
            font-size: 3.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #E0E7FF, #C7D2FE);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Course card */
        .c-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.2s;
        }

        .c-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(99, 102, 241, 0.1);
        }

        /* Badge */
        .lbadge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
        }

        .lb-beg {
            background: #ECFDF5;
            color: #059669;
        }

        .lb-mid {
            background: #FFF7ED;
            color: #EA580C;
        }

        .lb-adv {
            background: #FEF2F2;
            color: #DC2626;
        }

        /* Trusted logos row */
        .logos-row {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            align-items: center;
            justify-content: center;
        }

        .logo-item {
            font-size: 0.9rem;
            font-weight: 700;
            color: #9CA3AF;
            letter-spacing: -0.02em;
        }

        /* CTA section */
        .cta-bg {
            background: linear-gradient(135deg, #EEF2FF 0%, #F5F3FF 100%);
        }

        /* Rating stars */
        .star {
            color: #FBBF24;
        }
    </style>
</head>

<body x-data>

    {{-- NAV --}}
    <header class="nav-border sticky top-0 z-50 bg-white/95 backdrop-blur-md">
        <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="/" class="font-black text-xl tracking-tight">Career<span
                        style="color:#6366F1">180</span></a>
                <nav class="hidden md:flex items-center gap-5 text-sm font-medium text-[#6B7280]">
                    <a href="#courses" class="hover:text-[#111827] transition-colors">Courses</a>
                    <a href="#features" class="hover:text-[#111827] transition-colors">Features</a>
                    <a href="#how" class="hover:text-[#111827] transition-colors">How it works</a>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-indigo px-5 py-2 text-sm">Dashboard →</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-[#6B7280] hover:text-[#111827] transition-colors px-3 py-2">Log
                        in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-indigo px-5 py-2 text-sm">Get started free</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    {{-- HERO — split layout --}}
    <section class="hero-bg">
        <div class="max-w-6xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Left: copy --}}
            <div>
                <div
                    class="inline-flex items-center gap-2 bg-indigo-50 text-[#6366F1] text-xs font-semibold px-3 py-1.5 rounded-full mb-6 border border-indigo-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#6366F1] animate-pulse inline-block"></span>
                    6 courses · 200+ lessons live now
                </div>
                <h1 class="text-5xl lg:text-6xl font-black leading-tight tracking-tight mb-5">
                    The developer<br><span class="gradient-heading">learning platform</span><br>built to ship.
                </h1>
                <p class="text-[#6B7280] text-lg leading-relaxed mb-8 max-w-md">
                    Structured courses, HD screencasts, and progress tracking — everything you need to go from curious
                    to confident.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 mb-10">
                    <a href="{{ Route::has('register') ? route('register') : '#' }}"
                        class="btn-indigo px-7 py-3.5 text-base text-center">
                        Start learning free →
                    </a>
                    <a href="#courses" class="btn-border px-7 py-3.5 text-base text-center">
                        Browse courses
                    </a>
                </div>
                {{-- Social proof --}}
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-2">
                        @foreach (['bg-violet-200', 'bg-sky-200', 'bg-emerald-200', 'bg-rose-200', 'bg-amber-200'] as $c)
                            <div
                                class="w-9 h-9 rounded-full border-2 border-white {{ $c }} flex items-center justify-center text-sm">
                                😊</div>
                        @endforeach
                    </div>
                    <div>
                        <div class="flex items-center gap-1 text-sm">
                            <span class="star">★★★★★</span>
                            <span class="font-bold text-[#111827]">4.9</span>
                        </div>
                        <div class="text-xs text-[#9CA3AF]">from 2,400+ learners</div>
                    </div>
                </div>
            </div>
            {{-- Right: browser mockup --}}
            <div class="w-full">
                <div class="browser-wrap">
                    <div class="browser-chrome">
                        <div class="browser-dot bg-red-400"></div>
                        <div class="browser-dot bg-yellow-400"></div>
                        <div class="browser-dot bg-green-400"></div>
                        <div class="flex-1 bg-white rounded-md px-3 py-1 text-xs text-[#9CA3AF] ml-2">
                            career-180.test/courses</div>
                    </div>
                    <div class="bg-white p-5">
                        <div class="text-xs font-semibold text-[#6B7280] mb-3 tracking-widest">PUBLISHED COURSES</div>
                        @foreach ([['Laravel from Zero to Hero', 'Beginner', '#ECFDF5', '#059669', '6h 40m', 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=100&q=60'], ['Vue.js 3 Masterclass', 'Intermediate', '#FFF7ED', '#EA580C', '9h 10m', 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=100&q=60'], ['Full-Stack with Inertia', 'Advanced', '#FEF2F2', '#DC2626', '12h 05m', 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=100&q=60'], ['TDD with Pest', 'Advanced', '#FEF2F2', '#DC2626', '7h 20m', 'https://images.unsplash.com/photo-1564865878688-9a244444042a?w=100&q=60']] as [$title, $level, $bg, $col, $dur, $img])
                            <div class="mockup-row">
                                <img src="{{ $img }}" alt="{{ $title }}" class="mockup-thumbnail">
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-semibold text-[#111827] truncate">{{ $title }}</div>
                                    <div class="text-xs text-[#9CA3AF]">{{ $dur }}</div>
                                </div>
                                <span class="text-xs font-semibold px-1.5 py-0.5 rounded shrink-0"
                                    style="background:{{ $bg }};color:{{ $col }}">{{ $level }}</span>
                            </div>
                        @endforeach
                        <div class="mt-4 pt-3 border-t border-[#E5E7EB]">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-[#6B7280]">Your progress</span>
                                <span class="text-xs font-bold text-[#6366F1]">3 / 6 courses started</span>
                            </div>
                            <div class="mt-2 h-2 bg-[#F3F4F6] rounded-full overflow-hidden">
                                <div class="h-full w-1/2 bg-[#6366F1] rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TRUSTED BY --}}
    <div class="border-y border-[#E5E7EB] bg-[#F9FAFB]">
        <div class="max-w-6xl mx-auto px-6 py-8">
            <p class="text-center text-xs font-semibold text-[#9CA3AF] tracking-widest mb-6">TRUSTED BY DEVELOPERS AT
            </p>
            <div class="logos-row">
                @foreach (['Shopify', 'Tighten', 'LaravelNews', 'Nerd.io', 'DigitalOcean', 'Forge', 'Vapor'] as $logo)
                    <span class="logo-item">{{ $logo }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- FEATURES --}}
    <section id="features" class="max-w-6xl mx-auto px-6 py-20">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold tracking-widest text-[#6366F1] mb-3">FEATURES</p>
            <h2 class="text-4xl font-black">Everything you need to level up</h2>
            <p class="text-[#6B7280] mt-3 max-w-lg mx-auto">Built from the ground up to make learning effective,
                enjoyable, and measurable.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ([['🎬', 'HD Screencasts', 'Cinematic-quality code walkthroughs. See exactly how real developers think.'], ['🗺️', 'Structured Paths', 'Curated learning sequences from beginner to advanced — no guessing what\'s next.'], ['📈', 'Progress Tracking', 'Pick up exactly where you left off. Track lesson completions and course progress.'], ['🏅', 'Certificates', 'Earn a verified certificate when you complete a course. Share it on LinkedIn.'], ['🔓', 'Free Previews', 'Every course has free preview lessons. Try before you commit.'], ['⚡', 'Fast & Focused', 'No padding, no filler. Every lesson has a purpose. Respect your time.']] as [$icon, $title, $desc])
                <div class="feat-card">
                    <div class="feat-icon">{{ $icon }}</div>
                    <h3 class="font-bold text-base mb-2">{{ $title }}</h3>
                    <p class="text-sm text-[#6B7280] leading-relaxed">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- COURSES --}}
    <section id="courses" class="bg-[#F9FAFB] py-20">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <p class="text-xs font-semibold tracking-widest text-[#6366F1] mb-2">COURSES</p>
                    <h2 class="text-4xl font-black">Published & ready to watch</h2>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @php $cs = [['Laravel from Zero to Hero', 'Beginner', 'lb-beg', 18, '6h 40m', 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=70'], ['Vue.js 3 Masterclass', 'Intermediate', 'lb-mid', 24, '9h 10m', 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&q=70'], ['Full-Stack with Inertia', 'Advanced', 'lb-adv', 31, '12h 05m', 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=600&q=70'], ['REST API Design Patterns', 'Intermediate', 'lb-mid', 15, '4h 55m', 'https://images.unsplash.com/photo-1607706189992-eae578626c86?w=600&q=70'], ['TDD with Pest', 'Advanced', 'lb-adv', 20, '7h 20m', 'https://images.unsplash.com/photo-1564865878688-9a244444042a?w=600&q=70'], ['Tailwind CSS Deep Dive', 'Beginner', 'lb-beg', 12, '3h 30m', 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=600&q=70']]; @endphp
                @foreach ($cs as $c)
                    <a href="{{ Route::has('register') ? route('register') : '#' }}" class="c-card block group">
                        <div class="overflow-hidden">
                            <img src="{{ $c[5] }}" alt="{{ $c[0] }}"
                                class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-400">
                        </div>
                        <div class="p-5">
                            <span class="lbadge {{ $c[2] }}">{{ $c[1] }}</span>
                            <h3 class="font-bold text-sm mt-2 mb-3 leading-snug">{{ $c[0] }}</h3>
                            <div class="flex items-center justify-between text-xs text-[#9CA3AF]">
                                <span>{{ $c[3] }} lessons · {{ $c[4] }}</span>
                                <span class="font-semibold text-[#6366F1]">Enroll →</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section id="how" class="max-w-6xl mx-auto px-6 py-20">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold tracking-widest text-[#6366F1] mb-3">THE PROCESS</p>
            <h2 class="text-4xl font-black">Up and learning in 3 steps</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach ([['Register free', 'Create your account in under 60 seconds. No credit card required.'], ['Pick your path', 'Browse by topic or level. Free previews let you try before enrolling.'], ['Ship & grow', 'Complete lessons, track progress, earn certificates, and get hired.']] as $i => [$t, $d])
                <div class="relative">
                    <div class="step-num">0{{ $i + 1 }}</div>
                    <h3 class="text-xl font-bold mb-2">{{ $t }}</h3>
                    <p class="text-[#6B7280] text-sm leading-relaxed">{{ $d }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA BANNER --}}
    <section class="cta-bg py-20">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-black mb-4">Ready to start building?</h2>
            <p class="text-[#6B7280] text-lg mb-8 leading-relaxed">Join 10,000+ developers already learning on Career
                180. Free to start.</p>
            <a href="{{ Route::has('register') ? route('register') : '#' }}"
                class="btn-indigo inline-block px-10 py-4 text-base">
                Create Free Account →
            </a>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="border-t border-[#E5E7EB]">
        <div class="max-w-6xl mx-auto px-6 py-10 flex flex-col md:flex-row items-center justify-between gap-4">
            <span class="font-black text-lg">Career<span class="text-[#6366F1]">180</span></span>
            <p class="text-xs text-[#9CA3AF]">© {{ date('Y') }} Career 180. Built with Laravel, Livewire & love.
            </p>
            <div class="flex gap-6">
                <a href="{{ route('login') }}"
                    class="text-xs text-[#9CA3AF] hover:text-[#111827] transition-colors">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="text-xs text-[#9CA3AF] hover:text-[#111827] transition-colors">Register</a>
                @endif
            </div>
        </div>
    </footer>
</body>

</html>
