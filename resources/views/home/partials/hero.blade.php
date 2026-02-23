<section class="hero-bg">
    <div class="max-w-6xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-500 text-xs font-semibold px-3 py-1.5 rounded-full mb-6 border border-indigo-100">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse inline-block"></span>
                {{ $totalCourses }} courses live now
            </div>
            <h1 class="text-5xl lg:text-6xl font-black leading-tight tracking-tight mb-5">
                The developer<br><span class="gradient-heading">learning platform</span><br>built to ship.
            </h1>
            <p class="text-gray-500 text-lg leading-relaxed mb-8 max-w-md">
                Structured courses, HD screencasts, and progress tracking — everything you need to go from curious to confident.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 mb-10">
                <a href="{{ Route::has('register') ? route('register') : '#' }}" class="btn-indigo px-7 py-3.5 text-base text-center">
                    Start learning free →
                </a>
                <a href="#courses" class="btn-border px-7 py-3.5 text-base text-center">
                    Browse courses
                </a>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex -space-x-2">
                    @foreach (['bg-violet-200', 'bg-sky-200', 'bg-emerald-200', 'bg-rose-200', 'bg-amber-200'] as $c)
                        <div class="w-9 h-9 rounded-full border-2 border-white {{ $c }} flex items-center justify-center text-sm">😊</div>
                    @endforeach
                </div>
                <div>
                    <div class="flex items-center gap-1 text-sm">
                        <span class="star">★★★★★</span>
                        <span class="font-bold text-gray-900">4.9</span>
                    </div>
                    <div class="text-xs text-gray-400">from 2,400+ learners</div>
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="browser-wrap">
                <div class="browser-chrome">
                    <div class="browser-dot bg-red-400"></div>
                    <div class="browser-dot bg-yellow-400"></div>
                    <div class="browser-dot bg-green-400"></div>
                    <div class="flex-1 bg-white rounded-md px-3 py-1 text-xs text-gray-400 ml-2">career-180.test/courses</div>
                </div>
                <div class="bg-white p-5">
                    <div class="text-xs font-semibold text-gray-500 mb-3 tracking-widest">PLATFORM STATS</div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-black text-indigo-500">{{ $totalCourses }}</div>
                            <div class="text-xs text-gray-500 mt-1">Courses</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-black text-purple-500">50+</div>
                            <div class="text-xs text-gray-500 mt-1">Hours</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-black text-emerald-500">HD</div>
                            <div class="text-xs text-gray-500 mt-1">Quality</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-black text-amber-500">Free</div>
                            <div class="text-xs text-gray-500 mt-1">Preview</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">Learning progress</span>
                            <span class="text-xs font-bold text-indigo-500">Track your journey</span>
                        </div>
                        <div class="mt-2 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full w-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
