@php
    $week = [
        ['day' => 'Mon', 'time' => '6:00 PM', 'active' => true],
        ['day' => 'Tue', 'time' => 'Off', 'active' => false],
        ['day' => 'Wed', 'time' => '6:00 PM', 'active' => true],
        ['day' => 'Thu', 'time' => '6:00 PM', 'active' => true],
        ['day' => 'Fri', 'time' => '7:00 PM', 'active' => true],
        ['day' => 'Sat', 'time' => 'Special Events', 'active' => true],
        ['day' => 'Sun', 'time' => 'Off', 'active' => false],
    ];
@endphp

<x-section id="schedule">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <x-eyebrow icon="calendar">This Week</x-eyebrow>
            <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Stream Schedule</h2>
        </div>
        <p class="font-body text-sm text-text-secondary">Next stream in <span class="text-text-primary">14h 22m</span></p>
    </div>

    <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-7">
        @foreach ($week as $day)
            <div
                class="border p-5 text-center {{ $day['active'] ? 'border-primary/40 bg-card' : 'border-border bg-surface' }}"
                style="border-radius: var(--radius-base);"
            >
                <p class="font-heading text-sm font-semibold text-text-primary">{{ $day['day'] }}</p>
                <p class="mt-2 font-body text-xs {{ $day['active'] ? 'text-text-secondary' : 'text-text-muted' }}">
                    {{ $day['time'] }}
                </p>
            </div>
        @endforeach
    </div>

    <p class="mt-6 font-body text-sm text-text-muted">
        All times shown in your local timezone. Tournament appearances and special events are announced separately.
    </p>
</x-section>
