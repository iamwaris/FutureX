@php
    $snapshot = \App\Models\SnapshotStat::current();

    $stats = [
        ['label' => 'Followers', 'value' => $snapshot->followers, 'icon' => 'users'],
        ['label' => 'Subscribers', 'value' => $snapshot->subscribers, 'icon' => 'sparkles'],
        ['label' => 'Total Views', 'value' => $snapshot->total_views, 'icon' => 'eye'],
        ['label' => 'Years Creating', 'value' => $snapshot->years_creating, 'icon' => 'calendar'],
        ['label' => 'Videos Published', 'value' => $snapshot->videos_published, 'icon' => 'video'],
        ['label' => 'Community Members', 'value' => $snapshot->community_members, 'icon' => 'users'],
    ];
@endphp

<x-section id="snapshot" :band="true">
    <x-eyebrow icon="sparkles">By the Numbers</x-eyebrow>
    <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Not just a hobby anymore</h2>

    <div class="mt-10 grid grid-cols-2 gap-6 lg:grid-cols-3">
        @foreach ($stats as $stat)
            <div class="cos-card p-6">
                <span class="flex h-10 w-10 items-center justify-center bg-primary/10 text-primary" style="border-radius: calc(var(--radius-base) / 2);">
                    <x-ui-icon :name="$stat['icon']" class="h-5 w-5" />
                </span>
                <p class="mt-4 font-heading text-4xl font-bold tabular-nums text-text-primary sm:text-5xl">
                    <span data-counter-to="{{ $stat['value'] }}">0</span>
                </p>
                <p class="mt-2 font-body text-sm text-text-muted">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>
</x-section>
