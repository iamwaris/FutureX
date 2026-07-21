@php
    $platforms = [
        ['label' => 'Discord', 'stat' => '15,200 members'],
        ['label' => 'Reddit', 'stat' => '3,800 members'],
        ['label' => 'X', 'stat' => '42,100 followers'],
        ['label' => 'Instagram', 'stat' => '28,900 followers'],
        ['label' => 'TikTok', 'stat' => '61,300 followers'],
        ['label' => 'YouTube', 'stat' => '128,400 subscribers'],
    ];
@endphp

<x-section id="community">
    <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Community Hub</h2>

    <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($platforms as $platform)
            <a
                href="#"
                class="flex items-center justify-between border border-border bg-card p-6 transition hover:-translate-y-0.5"
                style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
            >
                <div>
                    <p class="font-heading text-lg font-semibold text-text-primary">{{ $platform['label'] }}</p>
                    <p class="mt-1 font-body text-sm text-text-secondary">{{ $platform['stat'] }}</p>
                </div>
                <svg class="h-5 w-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        @endforeach
    </div>
</x-section>
