@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-[1440px] px-6" style="padding-block: var(--section-spacing);">
        <x-eyebrow icon="tag">Partnerships</x-eyebrow>
        <h1 class="font-heading text-4xl font-bold text-text-primary sm:text-5xl">Sponsors & Partners</h1>
        <p class="mt-4 max-w-2xl font-body text-lg text-text-secondary">
            A look at the brands we've worked with, what those campaigns delivered, and what partners
            have to say about working together.
        </p>

        <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($sponsors as $sponsor)
                <div class="cos-card p-6">
                    <p class="font-heading text-xl font-semibold text-text-primary">{{ $sponsor->name }}</p>

                    @if ($sponsor->case_study)
                        <p class="mt-3 font-body text-sm text-text-secondary">{{ $sponsor->case_study }}</p>
                    @endif

                    @if ($sponsor->campaign_highlights)
                        <p class="mt-3 font-body text-xs uppercase tracking-wide text-text-muted">{{ $sponsor->campaign_highlights }}</p>
                    @endif

                    @if ($sponsor->testimonial_quote)
                        <blockquote class="mt-4 border-l-2 pl-4" style="border-color: color-mix(in srgb, var(--color-primary) 40%, transparent);">
                            <p class="font-body text-sm italic text-text-secondary">&ldquo;{{ $sponsor->testimonial_quote }}&rdquo;</p>
                            @if ($sponsor->testimonial_author)
                                <footer class="mt-2 font-body text-xs text-text-muted">{{ $sponsor->testimonial_author }}</footer>
                            @endif
                        </blockquote>
                    @endif

                    @if ($sponsor->website_url)
                        <a href="{{ $sponsor->website_url }}" target="_blank" rel="noopener" class="mt-4 flex items-center gap-1 font-body text-sm text-text-secondary hover:text-text-primary">
                            Visit site <x-ui-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="cos-card mt-12 flex flex-col items-center gap-4 p-10 text-center">
            <h2 class="font-heading text-2xl font-bold text-text-primary">Want to work together?</h2>
            <p class="max-w-md font-body text-text-secondary">Check out the full Media Kit for stats and audience demographics, then reach out.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a
                    href="{{ route('media-kit') }}"
                    class="border px-6 py-3 font-body font-semibold text-text-primary transition hover:-translate-y-0.5"
                    style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
                >
                    View Media Kit
                </a>
                <a
                    href="{{ route('contact') }}"
                    class="bg-primary px-6 py-3 font-body font-semibold text-white transition hover:-translate-y-0.5"
                    style="border-radius: var(--radius-base);"
                >
                    Business Inquiries
                </a>
            </div>
        </div>
    </div>
@endsection
