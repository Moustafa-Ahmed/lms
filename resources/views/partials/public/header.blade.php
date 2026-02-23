<header class="nav-border sticky top-0 z-50 bg-white/80 backdrop-blur-xl" x-data="{ mobileOpen: false }"
    @keydown.escape.window="mobileOpen = false">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 flex items-center justify-between h-[72px]">
        {{-- Logo --}}
        <div class="flex items-center gap-10">
            <a href="{{ route('home') }}" class="site-logo shrink-0">
                Career<span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-violet-500">180</span>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-500">
                <a href="{{ route('home') }}#courses"
                    class="hover:text-slate-900 transition-colors duration-200">Courses</a>
                <a href="{{ route('home') }}#features"
                    class="hover:text-slate-900 transition-colors duration-200">Features</a>
                <a href="{{ route('home') }}#how" class="hover:text-slate-900 transition-colors duration-200">How it
                    works</a>
                @isset($navigation)
                    {{ $navigation }}
                @endisset
            </nav>
        </div>

        {{-- Desktop CTA --}}
        <div class="hidden md:flex items-center gap-3">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors px-4 py-2"
                        onclick="this.disabled=true;this.form.submit();">
                        Log out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors px-4 py-2">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-indigo px-6 py-2.5 text-sm">
                        <span>Get started free</span>
                    </a>
                @endif
            @endauth
        </div>

        {{-- Mobile hamburger --}}
        <button @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-label="Toggle navigation menu"
            class="nav-hamburger md:hidden">
            <span x-show="!mobileOpen" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round">
                    <line x1="3" y1="6" x2="19" y2="6" />
                    <line x1="3" y1="11" x2="19" y2="11" />
                    <line x1="3" y1="16" x2="19" y2="16" />
                </svg>
            </span>
            <span x-show="mobileOpen" x-cloak aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round">
                    <line x1="4" y1="4" x2="18" y2="18" />
                    <line x1="18" y1="4" x2="4" y2="18" />
                </svg>
            </span>
        </button>
    </div>

    {{-- Mobile menu panel --}}
    <div x-show="mobileOpen" x-cloak x-transition:enter="nav-mobile-enter"
        x-transition:enter-start="nav-mobile-enter-start" x-transition:enter-end="nav-mobile-enter-end"
        x-transition:leave="nav-mobile-leave" x-transition:leave-start="nav-mobile-leave-start"
        x-transition:leave-end="nav-mobile-leave-end" class="md:hidden nav-mobile-panel"
        @click.outside="mobileOpen = false">
        <nav class="flex flex-col gap-1 py-3">
            <a href="{{ route('home') }}#courses" @click="mobileOpen = false" class="nav-mobile-link">Courses</a>
            <a href="{{ route('home') }}#features" @click="mobileOpen = false" class="nav-mobile-link">Features</a>
            <a href="{{ route('home') }}#how" @click="mobileOpen = false" class="nav-mobile-link">How it works</a>
            @isset($navigation)
                {{ $navigation }}
            @endisset
        </nav>

        <div class="nav-mobile-cta">
            @auth
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="nav-mobile-link w-full text-left"
                        onclick="this.disabled=true;this.form.submit();">
                        Log out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-mobile-link">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-indigo block text-center px-6 py-3 text-sm mt-1">
                        <span>Get started free</span>
                    </a>
                @endif
            @endauth
        </div>
    </div>
</header>
