<div x-data="{ showSuccess: false }" class="inline-block">
    @if(auth()->check())
        @if($isEnrolled)
            <a href="#lessons"
               class="btn-indigo inline-flex items-center gap-2 px-8 py-3.5 text-base"
               wire:navigate>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Continue Learning
            </a>
        @else
            <button
                type="button"
                wire:click="enroll"
                wire:loading.attr="disabled"
                class="btn-indigo inline-flex items-center gap-2 px-8 py-3.5 text-base"
            >
                <span wire:loading.remove wire:target="enroll">
                    Enroll Now — Free
                </span>
                <span wire:loading wire:target="enroll" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Enrolling...
                </span>
            </button>
        @endif
    @else
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('register') }}" class="btn-indigo px-8 py-3.5 text-base text-center">
                Enroll Now — Free
            </a>
            <span class="text-sm text-gray-500 flex items-center">
                or <a href="{{ route('login') }}" class="text-indigo-500 ml-1 hover:underline">log in</a>
            </span>
        </div>
    @endif

    <div
        x-show="showSuccess"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-init="@this.on('enrolled', () => { showSuccess = true; setTimeout(() => showSuccess = false, 3000) })"
        class="mt-4 p-3 bg-green-50 text-green-700 text-sm rounded-lg"
    >
        Successfully enrolled! Start learning now.
    </div>
</div>
