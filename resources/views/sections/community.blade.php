@php
    $discord = ['stat' => '15,200 members', 'glow' => '#5865F2'];
    $platforms = [
        ['name' => 'youtube', 'label' => 'YouTube', 'stat' => '128,400 subscribers', 'glow' => '#FF0000'],
        ['name' => 'tiktok', 'label' => 'TikTok', 'stat' => '61,300 followers', 'glow' => '#25F4EE'],
        ['name' => 'x', 'label' => 'X', 'stat' => '42,100 followers', 'glow' => '#000000'],
        ['name' => 'instagram', 'label' => 'Instagram', 'stat' => '28,900 followers', 'glow' => '#DD2A7B'],
        ['name' => 'reddit', 'label' => 'Reddit', 'stat' => '3,800 members', 'glow' => '#FF4500'],
    ];
    $avatars = ['A', 'M', 'K', 'J', 'R'];
@endphp

<x-section id="community">
    <x-eyebrow icon="users">Stay Connected</x-eyebrow>
    <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Community Hub</h2>

    {{-- Discord spotlight — the real home base for most creator communities --}}
    <a
        href="#"
        class="cos-card group relative mt-10 flex flex-col justify-between gap-8 overflow-hidden p-8 sm:flex-row sm:items-end"
        style="--card-glow: {{ $discord['glow'] }};"
    >
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.07]"
            style="background: linear-gradient(135deg, {{ $discord['glow'] }}, transparent 70%);"
        ></div>

        <div>
            <div class="flex items-center gap-4">
                <x-platform-badge name="discord" />
                <div>
                    <p class="font-heading text-xl font-semibold text-text-primary">Discord</p>
                    <p class="mt-0.5 font-body text-sm text-text-secondary">The main hub — chat, VOD reviews, giveaways</p>
                </div>
            </div>

            <div class="mt-6 flex items-center">
                @foreach ($avatars as $initial)
                    <span
                        class="-ml-2.5 flex h-9 w-9 items-center justify-center rounded-full border-2 text-xs font-bold text-white first:ml-0"
                        style="background: color-mix(in srgb, {{ $discord['glow'] }} 70%, var(--color-primary)); border-color: var(--color-card);"
                    >
                        {{ $initial }}
                    </span>
                @endforeach
                <span class="-ml-2.5 flex h-9 w-9 items-center justify-center rounded-full border-2 bg-surface text-[10px] font-bold text-text-secondary" style="border-color: var(--color-card);">
                    +15K
                </span>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <p class="font-heading text-4xl font-bold text-text-primary">{{ $discord['stat'] }}</p>
            <x-ui-icon name="arrow-right" class="h-5 w-5 shrink-0 text-text-muted transition group-hover:translate-x-1" />
        </div>
    </a>

    {{-- Supporting platforms --}}
    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-5">
        @foreach ($platforms as $platform)
            <a
                href="#"
                class="cos-card flex items-center gap-4 p-5"
                style="--card-glow: {{ $platform['glow'] }};"
            >
                <x-platform-badge :name="$platform['name']" />
                <div class="min-w-0">
                    <p class="font-heading text-sm font-semibold text-text-primary">{{ $platform['label'] }}</p>
                    <p class="mt-0.5 truncate font-body text-xs text-text-secondary">{{ $platform['stat'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
</x-section>
