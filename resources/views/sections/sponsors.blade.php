@php
    $sponsors = ['Aurora Gear', 'Nimbus Energy', 'Voidline PC', 'Fabled Apparel', 'Cortex Audio'];
@endphp

<x-section id="sponsors">
    <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Trusted By</h2>

    <div class="mt-10 flex flex-wrap items-center gap-x-12 gap-y-6">
        @foreach ($sponsors as $sponsor)
            <span class="font-heading text-xl font-semibold text-text-muted transition hover:text-text-primary">
                {{ $sponsor }}
            </span>
        @endforeach
    </div>

    <blockquote
        class="mt-12 border border-border bg-card p-8"
        style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
    >
        <p class="font-heading text-xl leading-relaxed text-text-primary">
            &ldquo;The campaign outperformed every other creator partnership we ran that quarter —
            professional from the first email to the final report.&rdquo;
        </p>
        <footer class="mt-4 font-body text-sm text-text-secondary">Marketing Lead, Aurora Gear</footer>
    </blockquote>
</x-section>
