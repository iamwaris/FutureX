@php
    $typeLabels = [
        'stream' => 'Stream',
        'charity' => 'Charity',
        'tournament' => 'Tournament',
        'meet-and-greet' => 'Meet & Greet',
    ];
@endphp

<div>
    <div class="cos-card p-6">
        <div class="flex items-center justify-between">
            <button type="button" wire:click="previousMonth" class="p-2 text-text-secondary hover:text-text-primary" aria-label="Previous month">
                <x-ui-icon name="arrow-right" class="h-5 w-5 rotate-180" />
            </button>
            <p class="font-heading text-lg font-semibold text-text-primary">{{ $month->format('F Y') }}</p>
            <button type="button" wire:click="nextMonth" class="p-2 text-text-secondary hover:text-text-primary" aria-label="Next month">
                <x-ui-icon name="arrow-right" class="h-5 w-5" />
            </button>
        </div>

        <div class="mt-6 grid grid-cols-7 gap-1 text-center font-body text-xs text-text-muted">
            @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $label)
                <div class="py-2">{{ $label }}</div>
            @endforeach
        </div>

        <div class="grid grid-cols-7 gap-1" wire:loading.class="opacity-50">
            @foreach ($days as $day)
                <div
                    class="min-h-[80px] border p-1.5 text-left {{ $day['inCurrentMonth'] ? '' : 'opacity-30' }}"
                    style="border-radius: calc(var(--radius-base) / 2); border-color: color-mix(in srgb, var(--color-border) 60%, transparent); {{ $day['isToday'] ? 'border-color: var(--color-primary);' : '' }}"
                >
                    <p class="font-body text-xs {{ $day['isToday'] ? 'font-bold text-primary' : 'text-text-muted' }}">
                        {{ $day['date']->day }}
                    </p>
                    <div class="mt-1 space-y-0.5">
                        @foreach ($day['events']->take(2) as $event)
                            <p class="truncate bg-primary/10 px-1 py-0.5 font-body text-[10px] text-text-primary" style="border-radius: 3px;" title="{{ $event->title }}">
                                {{ $event->title }}
                            </p>
                        @endforeach
                        @if ($day['events']->count() > 2)
                            <p class="font-body text-[10px] text-text-muted">+{{ $day['events']->count() - 2 }} more</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if ($upcoming->isNotEmpty())
        <div class="mt-8">
            <h2 class="font-heading text-xl font-bold text-text-primary">Upcoming</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($upcoming as $event)
                    <div class="cos-card p-5">
                        <span class="bg-surface px-2.5 py-1 font-body text-xs text-text-secondary" style="border-radius: calc(var(--radius-base) / 2);">
                            {{ $typeLabels[$event->type] ?? $event->type }}
                        </span>
                        <p class="mt-3 font-heading text-base font-semibold text-text-primary">{{ $event->title }}</p>
                        <p class="mt-1 font-body text-sm text-text-secondary">{{ $event->starts_at->format('M j, Y g:i A') }}</p>
                        @if ($event->location)
                            <p class="mt-1 font-body text-xs text-text-muted">{{ $event->location }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
