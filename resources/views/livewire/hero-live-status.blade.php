<div
    wire:poll.30s
    class="relative aspect-video overflow-hidden border border-border"
    style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation); background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));"
>
    <div class="absolute left-4 top-4 flex items-center gap-2">
        <x-platform-badge :name="$status->platform === 'none' ? 'twitch' : $status->platform" size="sm" />
        <span
            class="px-2.5 py-1 text-xs font-semibold text-white backdrop-blur {{ $status->isLive ? 'bg-error/80' : 'bg-black/40' }}"
            style="border-radius: calc(var(--radius-base) / 2);"
        >
            {{ $status->isLive ? 'LIVE' : 'OFFLINE' }}
        </span>
    </div>

    <div class="absolute inset-0 flex items-center justify-center">
        <span class="flex h-16 w-16 items-center justify-center rounded-full bg-white/25 backdrop-blur">
            <x-ui-icon name="play" solid class="h-7 w-7 text-white" />
        </span>
    </div>

    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-4">
        @if ($status->isLive)
            <p class="font-body text-sm font-medium text-white">{{ $status->title }}</p>
            @if ($status->viewerCount !== null)
                <p class="mt-0.5 font-body text-xs text-white/70">{{ number_format($status->viewerCount) }} watching</p>
            @endif
        @else
            <p class="font-body text-sm font-medium text-white">Offline right now</p>
            <p class="mt-0.5 font-body text-xs text-white/70">Check the schedule below</p>
        @endif
    </div>
</div>
