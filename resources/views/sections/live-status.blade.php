@php
    // Placeholder data — replaced by real Twitch/Kick/YouTube polling in M4.
    $isLive = false;
    $stream = [
        'platform' => 'Twitch',
        'game' => 'Valorant',
        'title' => 'Ranked grind → road to Radiant',
        'viewers' => 0,
        'duration' => '—',
        'next_stream_at' => 'Tomorrow, 6:00 PM',
    ];
@endphp

<x-section id="live-status">
    <div
        class="flex flex-col gap-8 border border-border bg-card p-8 lg:flex-row lg:items-center lg:justify-between"
        style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
    >
        <div class="flex items-start gap-4">
            <span class="relative mt-1.5 flex h-3 w-3 shrink-0">
                @if ($isLive)
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-error opacity-75"></span>
                @endif
                <span class="relative inline-flex h-3 w-3 rounded-full {{ $isLive ? 'bg-error' : 'bg-text-muted' }}"></span>
            </span>

            <div>
                <p class="font-heading text-2xl font-semibold text-text-primary">
                    {{ $isLive ? 'LIVE NOW' : 'Currently Offline' }}
                </p>
                <p class="mt-1 font-body text-text-secondary">
                    {{ $stream['title'] }}
                </p>
                <div class="mt-3 flex flex-wrap gap-x-6 gap-y-1 font-body text-sm text-text-muted">
                    <span>{{ $stream['platform'] }}</span>
                    <span>{{ $stream['game'] }}</span>
                    @if ($isLive)
                        <span>{{ number_format($stream['viewers']) }} viewers</span>
                        <span>{{ $stream['duration'] }}</span>
                    @else
                        <span>Next stream: {{ $stream['next_stream_at'] }}</span>
                    @endif
                </div>
            </div>
        </div>

        <a
            href="#"
            data-magnetic
            class="shrink-0 bg-primary px-6 py-3 text-center font-body font-semibold text-white transition hover:-translate-y-0.5"
            style="border-radius: var(--radius-base);"
        >
            {{ $isLive ? 'Watch Now' : 'Get Notified' }}
        </a>
    </div>
</x-section>
