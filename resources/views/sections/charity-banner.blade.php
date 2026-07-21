@php
    // Placeholder campaign data — a full fundraising-tracker backend is out
    // of scope here; Charity Mode is about the banner appearing, not a
    // donation-processing system.
    $goal = 10000;
    $raised = 6400;
    $percentage = min(100, round(($raised / $goal) * 100));
@endphp

<x-section id="charity-banner">
    <div class="cos-card relative overflow-hidden p-8 sm:p-10" style="--card-glow: var(--color-error);">
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.08]"
            style="background: linear-gradient(135deg, var(--color-error), transparent 70%);"
        ></div>

        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <span class="cos-chip inline-flex items-center gap-2 bg-surface px-4 py-1.5 text-sm text-text-secondary" style="border-radius: var(--radius-base);">
                    <x-ui-icon name="sparkles" solid class="h-4 w-4 text-error" />
                    Charity Campaign
                </span>
                <h2 class="mt-4 font-heading text-2xl font-bold text-text-primary sm:text-3xl">Every Dollar Doubled This Weekend</h2>
                <p class="mt-2 max-w-xl font-body text-text-secondary">
                    100% of stream donations go straight to the campaign — matched by sponsors up to $10,000.
                </p>
            </div>

            <a
                href="#"
                data-magnetic
                class="shrink-0 bg-error px-6 py-3 text-center font-body font-semibold text-white transition hover:-translate-y-0.5"
                style="border-radius: var(--radius-base);"
            >
                Donate Now
            </a>
        </div>

        <div class="mt-8">
            <div class="flex items-center justify-between font-body text-sm">
                <span class="font-semibold text-text-primary">${{ number_format($raised) }} raised</span>
                <span class="text-text-muted">of ${{ number_format($goal) }} goal</span>
            </div>
            <div class="mt-2 h-2.5 w-full overflow-hidden bg-surface" style="border-radius: 999px;">
                <div class="h-full bg-error" style="width: {{ $percentage }}%; border-radius: 999px;"></div>
            </div>
        </div>
    </div>
</x-section>
