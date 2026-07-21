@php
    $sponsors = ['Aurora Gear', 'Nimbus Energy', 'Voidline PC', 'Fabled Apparel', 'Cortex Audio'];
@endphp

<x-section id="sponsors">
    <x-eyebrow icon="tag">Partnerships</x-eyebrow>
    <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Trusted By</h2>

    <div class="mt-10 flex flex-wrap gap-4">
        @foreach ($sponsors as $sponsor)
            <span
                class="cos-chip bg-surface px-5 py-3 font-heading text-lg font-semibold text-text-secondary transition hover:text-text-primary"
                style="border-radius: var(--radius-base);"
            >
                {{ $sponsor }}
            </span>
        @endforeach
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
