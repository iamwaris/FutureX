@php
    $platforms = [
        ['name' => 'discord', 'label' => 'Discord', 'stat' => '15,200 members'],
        ['name' => 'reddit', 'label' => 'Reddit', 'stat' => '3,800 members'],
        ['name' => 'x', 'label' => 'X', 'stat' => '42,100 followers'],
        ['name' => 'instagram', 'label' => 'Instagram', 'stat' => '28,900 followers'],
        ['name' => 'tiktok', 'label' => 'TikTok', 'stat' => '61,300 followers'],
        ['name' => 'youtube', 'label' => 'YouTube', 'stat' => '128,400 subscribers'],
    ];
@endphp

<x-section id="community">
    <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Community Hub</h2>

    <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($platforms as $platform)
            <a
                href="#"
                class="flex items-center justify-between border border-border bg-card p-6 transition hover:-translate-y-0.5"
                style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
            >
                <div class="flex items-center gap-4">
                    <x-platform-badge :name="$platform['name']" />
                    <div>
                        <p class="font-heading text-lg font-semibold text-text-primary">{{ $platform['label'] }}</p>
                        <p class="mt-1 font-body text-sm text-text-secondary">{{ $platform['stat'] }}</p>
                    </div>
                </div>
                <x-ui-icon name="arrow-right" class="h-5 w-5 text-text-muted" />
            </a>
        @endforeach
    </div>
</x-section>
