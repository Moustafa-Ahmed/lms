<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
        <livewire:timezone-sync />
    </flux:main>
</x-layouts::app.sidebar>
