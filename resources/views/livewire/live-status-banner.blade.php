<div
    wire:poll.30s
    class="cos-card flex flex-col gap-8 p-8 lg:flex-row lg:items-center lg:justify-between"
    style="--card-glow: {{ $status->isLive ? 'var(--color-error)' : 'var(--color-primary)' }};"
>
    <div class="flex items-start gap-4">
        <x-platform-badge :name="$status->platform === 'none' ? 'twitch' : $status->platform" />

        <div>
            <div class="flex items-center gap-2">
                <span class="relative flex h-2.5 w-2.5 shrink-0">
                    @if ($status->isLive)
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-error opacity-75"></span>
                    @endif
                    <span class="relative inline-flex h-2.5 w-2.5 rounded-full {{ $status->isLive ? 'bg-error' : 'bg-text-muted' }}"></span>
                </span>
                <p class="font-heading text-2xl font-semibold text-text-primary">
                    {{ $status->isLive ? 'LIVE NOW' : 'Currently Offline' }}
                </p>
            </div>

            @if ($status->isLive)
                <p class="mt-1 font-body text-text-secondary">{{ $status->title }}</p>
                <div class="mt-3 flex flex-wrap gap-x-6 gap-y-1 font-body text-sm text-text-muted">
                    <span class="capitalize">{{ $status->platform }}</span>
                    @if ($status->category)
                        <span>{{ $status->category }}</span>
                    @endif
                    @if ($status->viewerCount !== null)
                        <span>{{ number_format($status->viewerCount) }} viewers</span>
                    @endif
                    @if ($status->durationForHumans())
                        <span>{{ $status->durationForHumans() }}</span>
                    @endif
                </div>
            @else
                <p class="mt-1 font-body text-text-secondary">Check the schedule below for the next stream.</p>
            @endif
        </div>
    </div>

    <a
        href="{{ $status->watchUrl ?? '#schedule' }}"
        data-magnetic
        class="shrink-0 bg-primary px-6 py-3 text-center font-body font-semibold text-white transition hover:-translate-y-0.5"
        style="border-radius: var(--radius-base);"
    >
        {{ $status->isLive ? 'Watch Now' : 'Get Notified' }}
    </a>
</div>
