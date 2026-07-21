@php
    $stats = [
        ['label' => 'Followers', 'value' => 128400],
        ['label' => 'Subscribers', 'value' => 4200],
        ['label' => 'Total Views', 'value' => 18500000],
        ['label' => 'Years Creating', 'value' => 6],
        ['label' => 'Videos Published', 'value' => 940],
        ['label' => 'Community Members', 'value' => 15200],
    ];
@endphp

<x-section id="snapshot">
    <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">By the Numbers</h2>

    <div class="mt-10 grid grid-cols-2 gap-6 lg:grid-cols-3">
        @foreach ($stats as $stat)
            <div
                class="border border-border bg-card p-6"
                style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
            >
                <p class="font-heading text-4xl font-bold text-text-primary">
                    <span data-counter-to="{{ $stat['value'] }}">0</span>
                </p>
                <p class="mt-2 font-body text-sm text-text-muted">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>
</x-section>
