@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-[1440px] px-6" style="padding-block: var(--section-spacing);">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <div>
                <x-eyebrow icon="briefcase">Media Kit</x-eyebrow>
                <h1 class="font-heading text-4xl font-bold text-text-primary sm:text-5xl">Partner With Us</h1>
                <p class="mt-4 max-w-2xl font-body text-lg text-text-secondary">{{ $mediaKit->bio }}</p>
            </div>
            <a
                href="{{ route('media-kit.pdf') }}"
                data-magnetic
                class="flex shrink-0 items-center gap-2 bg-primary px-6 py-3 font-body font-semibold text-white transition hover:-translate-y-0.5"
                style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
            >
                <x-ui-icon name="download" class="h-5 w-5" />
                Download PDF
            </a>
        </div>

        @if (!empty($mediaKit->brand_values))
            <div class="mt-6 flex flex-wrap gap-3">
                @foreach ($mediaKit->brand_values as $value)
                    <span class="cos-chip bg-surface px-4 py-1.5 font-body text-sm text-text-secondary" style="border-radius: var(--radius-base);">
                        {{ $value }}
                    </span>
                @endforeach
            </div>
        @endif

        {{-- Reach --}}
        <div class="mt-12 grid grid-cols-2 gap-6 lg:grid-cols-4">
            @foreach ([
                ['label' => 'Followers', 'value' => $snapshot->followers],
                ['label' => 'Avg. Viewers', 'value' => $mediaKit->avg_viewers],
                ['label' => 'Peak Viewers', 'value' => $mediaKit->peak_viewers],
                ['label' => 'Monthly Impressions', 'value' => $mediaKit->monthly_impressions],
            ] as $stat)
                <div class="cos-card p-6">
                    <p class="font-heading text-3xl font-bold tabular-nums text-text-primary sm:text-4xl">
                        {{ number_format($stat['value']) }}
                    </p>
                    <p class="mt-2 font-body text-sm text-text-muted">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Demographics --}}
        <div class="mt-12 grid grid-cols-1 gap-6 lg:grid-cols-2">
            @foreach ([
                ['title' => 'Age Ranges', 'data' => $mediaKit->age_ranges],
                ['title' => 'Gender Distribution', 'data' => $mediaKit->gender_distribution],
                ['title' => 'Languages', 'data' => $mediaKit->languages],
                ['title' => 'Geographic Breakdown', 'data' => $mediaKit->geographic_breakdown],
            ] as $group)
                @if (!empty($group['data']))
                    <div class="cos-card p-6">
                        <h2 class="font-heading text-lg font-semibold text-text-primary">{{ $group['title'] }}</h2>
                        <div class="mt-4 space-y-4">
                            @foreach ($group['data'] as $row)
                                <x-stat-bar :label="$row['label']" :percentage="$row['percentage']" />
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Past sponsors --}}
        @if ($sponsors->isNotEmpty())
            <div class="mt-12">
                <h2 class="font-heading text-2xl font-bold text-text-primary">Previous Partnerships</h2>
                <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($sponsors as $sponsor)
                        <div class="cos-card p-6">
                            <p class="font-heading text-lg font-semibold text-text-primary">{{ $sponsor->name }}</p>
                            @if ($sponsor->case_study)
                                <p class="mt-2 font-body text-sm text-text-secondary">{{ $sponsor->case_study }}</p>
                            @endif
                            @if ($sponsor->campaign_highlights)
                                <p class="mt-2 font-body text-xs text-text-muted">{{ $sponsor->campaign_highlights }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="cos-card mt-12 flex flex-col items-center gap-4 p-10 text-center">
            <h2 class="font-heading text-2xl font-bold text-text-primary">Ready to talk?</h2>
            <p class="max-w-md font-body text-text-secondary">Send over your campaign details and we'll get back to you within 48 hours.</p>
            <a
                href="{{ route('contact') }}"
                class="bg-primary px-6 py-3 font-body font-semibold text-white transition hover:-translate-y-0.5"
                style="border-radius: var(--radius-base);"
            >
                Business Inquiries
            </a>
        </div>
    </div>
@endsection
