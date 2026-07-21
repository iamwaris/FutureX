@php
    $content = [
        ['platform' => 'youtube', 'label' => 'YouTube', 'title' => 'How I Reached Radiant Solo Queue', 'pinned' => true],
        ['platform' => 'twitch', 'label' => 'Twitch VOD', 'title' => '12-Hour Charity Marathon Highlights', 'pinned' => false],
        ['platform' => 'tiktok', 'label' => 'TikTok', 'title' => 'Clutch 1v4 (Full Reaction)', 'pinned' => false],
        ['platform' => 'instagram', 'label' => 'Instagram Reels', 'title' => 'Behind the Scenes: Studio Setup Tour', 'pinned' => false],
    ];
@endphp

<x-section id="featured-content">
    <div class="flex items-baseline justify-between">
        <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Featured Content</h2>
        <a href="#" class="flex items-center gap-1 font-body text-sm text-text-secondary hover:text-text-primary">
            View library <x-ui-icon name="arrow-right" class="h-4 w-4" />
        </a>
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
                        style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); opacity: 0.35;"
                    ></div>

                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-white/25 backdrop-blur transition group-hover:scale-110">
                            <x-ui-icon name="play" solid class="h-5 w-5 text-white" />
                        </span>
                    </div>

                    <div class="absolute left-3 top-3">
                        <x-platform-badge :name="$item['platform']" size="sm" />
                    </div>

                    @if ($item['pinned'])
                        <span
                            class="absolute right-3 top-3 bg-primary px-2.5 py-1 text-xs font-semibold text-white"
                            style="border-radius: calc(var(--radius-base) / 2);"
                        >
                            Pinned
                        </span>
                    @endif
                </div>
                <div class="p-4">
                    <p class="font-body text-xs uppercase tracking-wide text-text-muted">{{ $item['label'] }}</p>
                    <p class="mt-1 font-heading text-base font-semibold text-text-primary">{{ $item['title'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</x-section>
