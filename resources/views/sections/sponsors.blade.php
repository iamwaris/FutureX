@php
    $sponsors = \App\Models\Sponsor::query()->where('is_featured', true)->ordered()->get();
    $testimonial = $sponsors->first(fn ($sponsor) => filled($sponsor->testimonial_quote));
@endphp

<x-section id="sponsors">
    <div class="flex items-end justify-between">
        <div>
            <x-eyebrow icon="tag">Partnerships</x-eyebrow>
            <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Trusted By</h2>
        </div>
        <a href="{{ route('sponsors') }}" class="flex items-center gap-1 font-body text-sm text-text-secondary hover:text-text-primary">
            View all <x-ui-icon name="arrow-right" class="h-4 w-4" />
        </a>
    </div>

    <div class="cos-marquee-mask relative mt-10 overflow-hidden">
        <div class="cos-marquee-track flex w-max items-center gap-16">
            @foreach ($sponsors->concat($sponsors) as $sponsor)
                <span
                    class="shrink-0 font-heading text-2xl font-bold text-text-muted opacity-60 transition duration-300 hover:scale-105 hover:text-text-primary hover:opacity-100 sm:text-3xl"
                >
                    {{ $sponsor->name }}
                </span>
            @endforeach
        </div>
    </div>

    @if ($testimonial)
        <blockquote class="cos-card relative mt-12 p-8">
            <x-ui-icon name="quote" solid class="h-8 w-8 text-primary/30" />
            <p class="mt-4 font-heading text-xl leading-relaxed text-text-primary">
                {{ $testimonial->testimonial_quote }}
            </p>
            <footer class="mt-4 font-body text-sm text-text-secondary">{{ $testimonial->testimonial_author }}</footer>
        </blockquote>
    @endif
</x-section>
