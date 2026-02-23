<footer class="site-footer">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
            <div class="md:col-span-2">
                <a href="{{ route('home') }}" class="site-logo text-white">
                    Career<span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-violet-400">180</span>
                </a>
                <p class="text-slate-500 text-sm leading-relaxed mt-4 max-w-sm">
                    The developer learning platform built to ship. Structured courses, HD screencasts, and clear
                    learning paths.
                </p>
            </div>
            <div>
                <h4 class="text-xs font-bold text-slate-300 tracking-wider uppercase mb-4">Platform</h4>
                <div class="flex flex-col gap-2.5">
                    <a href="{{ route('home') }}#courses" class="footer-link">Courses</a>
                    <a href="{{ route('home') }}#features" class="footer-link">Features</a>
                    <a href="{{ route('home') }}#how" class="footer-link">How it works</a>
                </div>
            </div>
            <div>
                <h4 class="text-xs font-bold text-slate-300 tracking-wider uppercase mb-4">Account</h4>
                <div class="flex flex-col gap-2.5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="footer-link">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="footer-link">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="footer-link">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        <div class="footer-divider"></div>
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-8">
            <p class="text-xs text-slate-600">
                © {{ date('Y') }} Career 180. Built with Laravel, Livewire & love.
            </p>
            <p class="text-xs text-slate-600">
                Crafted for developers who ship.
            </p>
        </div>
    </div>
</footer>
