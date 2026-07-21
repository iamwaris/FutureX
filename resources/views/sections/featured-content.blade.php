@php
    $content = [
        ['platform' => 'YouTube', 'title' => 'How I Reached Radiant Solo Queue', 'pinned' => true],
        ['platform' => 'Twitch VOD', 'title' => '12-Hour Charity Marathon Highlights', 'pinned' => false],
        ['platform' => 'TikTok', 'title' => 'Clutch 1v4 (Full Reaction)', 'pinned' => false],
        ['platform' => 'Instagram Reels', 'title' => 'Behind the Scenes: Studio Setup Tour', 'pinned' => false],
    ];
@endphp

<x-section id="featured-content">
    <div class="flex items-baseline justify-between">
        <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Featured Content</h2>
        <a href="#" class="font-body text-sm text-text-secondary hover:text-text-primary">View library →</a>
    </div>

    <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($content as $item)
            <div
                class="group overflow-hidden border border-border bg-card"
                style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
            >
                <div class="relative aspect-video overflow-hidden bg-surface">
                    <div
                        class="h-full w-full transition duration-500 group-hover:scale-105"
                        style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); opacity: 0.25;"
                    ></div>
                    @if ($item['pinned'])
                        <span
                            class="absolute left-3 top-3 bg-primary px-2.5 py-1 text-xs font-semibold text-white"
                            style="border-radius: calc(var(--radius-base) / 2);"
                        >
                            Pinned
                        </span>
                    @endif
                </div>
                <div class="p-4">
                    <p class="font-body text-xs uppercase tracking-wide text-text-muted">{{ $item['platform'] }}</p>
                    <p class="mt-1 font-heading text-base font-semibold text-text-primary">{{ $item['title'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</x-section>
