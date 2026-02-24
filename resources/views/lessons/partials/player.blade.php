<div x-data="{
    player: null,
    init() {
        this.player = new Plyr(this.$refs.video, {
            controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'],
            iconUrl: 'https://cdn.plyr.io/3.7.8/plyr.svg',
        });
    },
    destroy() {
        if (this.player) {
            this.player.destroy();
            this.player = null;
        }
    }
}" x-init="init()" x-on:destroy.window="destroy()" x-cloak
    class="w-full h-full plyr-container">
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

@push('styles')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css">
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .plyr-container {
            --plyr-color-main: #6366f1;
            --plyr-video-background: #111827;
            --plyr-menu-background: #ffffff;
            --plyr-menu-color: #1f2937;
            --plyr-tooltip-background: #1f2937;
            --plyr-tooltip-color: #ffffff;
        }

        .plyr-container .plyr {
            width: 100%;
            height: 100%;
        }

        .plyr-container .plyr__video-wrapper {
            height: 100%;
        }

        .plyr-container .plyr__control--overlaid {
            background: rgba(99, 102, 241, 0.9);
        }

        .plyr-container .plyr__control--overlaid:hover {
            background: rgba(99, 102, 241, 1);
        }

        .plyr-container .plyr--full-ui.plyr--video .plyr__control.plyr__tab-focus,
        .plyr-container .plyr--full-ui.plyr--video .plyr__control:hover,
        .plyr-container .plyr--full-ui.plyr--video .plyr__control[aria-expanded=true] {
            background: #6366f1;
        }

        .plyr-container .plyr__progress__buffer {
            background: rgba(255, 255, 255, 0.25);
        }

        .plyr-container .plyr--video .plyr__control.plyr__tab-focus,
        .plyr-container .plyr--video .plyr__control:hover,
        .plyr-container .plyr--video .plyr__control[aria-expanded=true] {
            background: #6366f1;
        }

        .plyr-container .plyr__control svg {
            filter: none;
        }

        .plyr-container .plyr__time {
            color: #ffffff;
        }

        .plyr-container .plyr__tooltip {
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
        }
    </style>
@endpush
