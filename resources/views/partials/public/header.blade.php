<header class="nav-border sticky top-0 z-50 bg-white/95 backdrop-blur-md">
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-16">
        <div class="flex items-center gap-8">
            <a href="{{ route('home') }}" class="font-black text-xl tracking-tight">
                Career<span class="text-indigo-500">180</span>
            </a>
            <nav class="hidden md:flex items-center gap-5 text-sm font-medium text-gray-500">
                <a href="{{ route('home') }}#courses" class="hover:text-gray-900 transition-colors">Courses</a>
                @isset($navigation)
                    {{ $navigation }}
                @endisset
            </nav>
        </div>
        <div class="flex items-center gap-3">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors px-3 py-2"
                        onclick="this.disabled=true;this.form.submit();"
                    >
                        Log out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors px-3 py-2">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-indigo px-5 py-2 text-sm">Get started free</a>
                @endif
            @endauth
        </div>
    </div>
</header>
