<div x-data="lessonPlayer({
    progressUrl: '{{ $progressUrl }}',
    completeUrl: '{{ $completeUrl }}',
    csrfToken: '{{ csrf_token() }}',
    isEnrolled: {{ $isEnrolled ? 'true' : 'false' }},
})" x-on:destroy.window="destroy()" x-cloak class="w-full h-full plyr-container">
    @if ($lesson->video_url)
        <video x-ref="video" class="plyr-video" playsinline controls preload="metadata"
            data-poster="{{ $lesson->course->image_url }}">
            <source src="{{ $lesson->video_url }}" type="video/mp4">
        </video>
    @else
        <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-400">
            <div class="text-center">
                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm">No video available</p>
            </div>
        </div>
    @endif
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
