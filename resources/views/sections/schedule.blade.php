@php
    // weekday follows ISO (Mon=1..Sun=7); hour_utc is null on off days.
    // Real schedule data + timezone-aware storage lands with the admin
    // Content Manager (M3) — this proves the countdown/timezone logic works.
    $week = [
        ['day' => 'Mon', 'weekday' => 1, 'hour_utc' => 22, 'game' => 'Valorant'],
        ['day' => 'Tue', 'weekday' => 2, 'hour_utc' => null, 'game' => null],
        ['day' => 'Wed', 'weekday' => 3, 'hour_utc' => 22, 'game' => 'Valorant'],
        ['day' => 'Thu', 'weekday' => 4, 'hour_utc' => 22, 'game' => 'Just Chatting'],
        ['day' => 'Fri', 'weekday' => 5, 'hour_utc' => 23, 'game' => 'Community Night'],
        ['day' => 'Sat', 'weekday' => 6, 'hour_utc' => 20, 'game' => 'Special Event'],
        ['day' => 'Sun', 'weekday' => 7, 'hour_utc' => null, 'game' => null],
    ];
@endphp

<x-section id="schedule">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <x-eyebrow icon="calendar">This Week</x-eyebrow>
            <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Stream Schedule</h2>
        </div>
        <div class="text-right">
            <p class="font-body text-sm text-text-secondary">Next stream in</p>
            <p class="font-heading text-2xl font-bold text-text-primary" data-countdown>—</p>
        </div>
    </div>

    <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-7">
        @foreach ($week as $day)
            <div
                class="schedule-day cos-card p-5 text-center {{ $day['hour_utc'] === null ? 'opacity-60' : '' }}"
                data-weekday="{{ $day['weekday'] }}"
                @if ($day['hour_utc'] !== null) data-hour-utc="{{ $day['hour_utc'] }}" @endif
            >
                <p class="font-heading text-sm font-semibold text-text-primary">{{ $day['day'] }}</p>

                @if ($day['hour_utc'] !== null)
                    <p class="local-time mt-2 font-body text-xs text-text-secondary">&nbsp;</p>
                    <p class="mt-1 font-body text-[11px] text-text-muted">{{ $day['game'] }}</p>
                @else
                    <p class="mt-2 font-body text-xs text-text-muted">Off</p>
                @endif
            </div>
        @endforeach
    </div>

    <p class="mt-6 font-body text-sm text-text-muted">
        Times above are converted to your local timezone automatically. Tournament appearances and
        charity streams are announced separately in Events.
    </p>
</x-section>
