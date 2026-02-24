<div x-data="{
    player: null,
    init() {
        this.player = new Plyr(this.$refs.video, {
            controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'],
            autoplay: {{ $autoplay ? 'true' : 'false' }},
        });

        this.$watch('$el', () => {
            if (this.player) {
                this.player.destroy();
            }
        });
    },
    destroy() {
        if (this.player) {
            this.player.destroy();
        }
    }
}" x-init="init" x-on:destroy.window="destroy()" class="w-full h-full">
    @if ($lesson->video_url)
        <video x-ref="video" class="plyr-video" playsinline controls data-poster="{{ $lesson->course->image_url }}">
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

@push('styles')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css">
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <style>
        .plyr-video-container .plyr {
            width: 100%;
            height: 100%;
        }

        .plyr-video-container .plyr__video-wrapper {
            height: 100%;
        }
    </style>
@endpush
