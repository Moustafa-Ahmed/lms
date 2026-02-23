<div class="border-y border-gray-200 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6 py-8">
        <p class="text-center text-xs font-semibold text-gray-400 tracking-widest mb-6">TRUSTED BY DEVELOPERS AT</p>
        <div class="logos-row">
            @foreach (['Shopify', 'Tighten', 'LaravelNews', 'Nerd.io', 'DigitalOcean', 'Forge', 'Vapor'] as $logo)
                <span class="logo-item">{{ $logo }}</span>
            @endforeach
        </div>
    </div>
</div>
