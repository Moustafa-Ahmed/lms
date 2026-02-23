<div class="trusted-section">
    <div class="py-6">
        <p class="text-center text-[0.65rem] font-bold text-slate-400 tracking-[0.15em] uppercase mb-5">Trusted by
            developers at</p>
        <div class="relative overflow-hidden">
            <div class="logos-track">
                @php $logos = ['Shopify', 'Tighten', 'LaravelNews', 'Nerd.io', 'DigitalOcean', 'Forge', 'Vapor']; @endphp
                @foreach ([...$logos, ...$logos] as $logo)
                    <span class="logo-item">{{ $logo }}</span>
                    <span class="text-slate-200 select-none" aria-hidden="true">·</span>
                @endforeach
            </div>
        </div>
    </div>
</div>
