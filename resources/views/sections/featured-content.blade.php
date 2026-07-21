@php
    $spotlight = ['platform' => 'youtube', 'label' => 'YouTube', 'title' => 'How I Reached Radiant Solo Queue', 'subtitle' => 'A full breakdown of the 40-game climb, mistakes and all.'];
    $rest = [
        ['platform' => 'twitch', 'label' => 'Twitch VOD', 'title' => '12-Hour Charity Marathon Highlights'],
        ['platform' => 'tiktok', 'label' => 'TikTok', 'title' => 'Clutch 1v4 (Full Reaction)'],
        ['platform' => 'instagram', 'label' => 'Instagram Reels', 'title' => 'Studio Setup Tour'],
        ['platform' => 'twitch', 'label' => 'Twitch Clips', 'title' => 'Chat Loses It Over This Play'],
    ];
@endphp

<x-section id="featured-content">
    <div class="flex items-end justify-between">
        <div>
            <x-eyebrow icon="play">Latest Drops</x-eyebrow>
            <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Featured Content</h2>
        </div>
        <a href="#" class="flex items-center gap-1 font-body text-sm text-text-secondary hover:text-text-primary">
            View library <x-ui-icon name="arrow-right" class="h-4 w-4" />
        </a>
    </div>

    <div class="mt-10 grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Spotlight card --}}
        <div class="cos-card group overflow-hidden lg:col-span-2">
            <div class="relative aspect-[16/9] overflow-hidden bg-surface lg:aspect-auto lg:h-full">
                <div
                    class="h-full w-full transition duration-500 group-hover:scale-105"
                    style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); opacity: 0.35;"
                ></div>

                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="flex h-16 w-16 items-center justify-center rounded-full bg-white/25 backdrop-blur transition group-hover:scale-110">
                        <x-ui-icon name="play" solid class="h-7 w-7 text-white" />
                    </span>
                </div>

                <div class="absolute left-4 top-4">
                    <x-platform-badge :name="$spotlight['platform']" />
                </div>

                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                    <p class="font-body text-xs uppercase tracking-wide text-white/70">{{ $spotlight['label'] }}</p>
                    <p class="mt-1 font-heading text-xl font-semibold text-white">{{ $spotlight['title'] }}</p>
                    <p class="mt-1 font-body text-sm text-white/70">{{ $spotlight['subtitle'] }}</p>
                </div>
            </div>
        </div>

        {{-- Supporting grid --}}
        <div class="grid grid-cols-2 gap-6">
            @foreach ($rest as $item)
                <div class="cos-card group overflow-hidden">
                    <div class="relative aspect-square overflow-hidden bg-surface">
                        <div
                            class="h-full w-full transition duration-500 group-hover:scale-105"
                            style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); opacity: 0.3;"
                        ></div>

                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white/25 backdrop-blur transition group-hover:scale-110">
                                <x-ui-icon name="play" solid class="h-4 w-4 text-white" />
                            </span>
                        </div>

                        <div class="absolute left-2 top-2">
                            <x-platform-badge :name="$item['platform']" size="sm" />
                        </div>
                    </div>
                    <div class="p-3">
                        <p class="font-heading text-xs font-semibold leading-snug text-text-primary">{{ $item['title'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-section>
