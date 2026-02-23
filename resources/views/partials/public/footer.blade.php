<footer class="border-t border-gray-200 mt-12">
    <div class="max-w-6xl mx-auto px-6 py-10 flex flex-col md:flex-row items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="font-black text-lg">
            Career<span class="text-indigo-500">180</span>
        </a>
        <p class="text-xs text-gray-400">
            © {{ date('Y') }} Career 180. Built with Laravel, Livewire & love.
        </p>
        <div class="flex gap-6">
            @auth
                <a href="{{ route('dashboard') }}" class="text-xs text-gray-400 hover:text-gray-900 transition-colors">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-xs text-gray-400 hover:text-gray-900 transition-colors">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-xs text-gray-400 hover:text-gray-900 transition-colors">
                        Register
                    </a>
                @endif
            @endauth
        </div>
    </div>
</footer>
