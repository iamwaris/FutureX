@php
    $sponsors = ['Aurora Gear', 'Nimbus Energy', 'Voidline PC', 'Fabled Apparel', 'Cortex Audio', 'Halcyon Media'];
@endphp

<x-section id="sponsors">
    <x-eyebrow icon="tag">Partnerships</x-eyebrow>
    <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Trusted By</h2>

    <div class="cos-marquee-mask relative mt-10 overflow-hidden">
        <div class="cos-marquee-track flex w-max items-center gap-16">
            @foreach ([...$sponsors, ...$sponsors] as $sponsor)
                <span
                    class="shrink-0 font-heading text-2xl font-bold text-text-muted opacity-60 transition duration-300 hover:scale-105 hover:text-text-primary hover:opacity-100 sm:text-3xl"
                >
                    {{ $sponsor }}
                </span>
            @endforeach
        </div>
    </div>

    <blockquote class="cos-card relative mt-12 p-8">
        <x-ui-icon name="quote" solid class="h-8 w-8 text-primary/30" />
        <p class="mt-4 font-heading text-xl leading-relaxed text-text-primary">
            The campaign outperformed every other creator partnership we ran that quarter —
            professional from the first email to the final report.
        </p>
        <footer class="mt-4 font-body text-sm text-text-secondary">Marketing Lead, Aurora Gear</footer>
    </blockquote>
</x-section>
