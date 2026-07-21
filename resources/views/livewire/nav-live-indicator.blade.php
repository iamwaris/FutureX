<div wire:poll.30s class="flex items-center gap-2 text-sm text-text-secondary">
    <span class="relative flex h-2.5 w-2.5">
        @if ($status->isLive)
            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-error opacity-75"></span>
        @endif
        <span class="relative inline-flex h-2.5 w-2.5 rounded-full {{ $status->isLive ? 'bg-error' : 'bg-text-muted' }}"></span>
    </span>
    {{ $status->isLive ? 'LIVE' : 'OFFLINE' }}
</div>
