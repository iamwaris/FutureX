<x-section id="hero" class="relative overflow-hidden pb-20">
    {{-- Animated gradient backdrop derived from the brand tokens, not hardcoded hues. --}}
    <div
        class="pointer-events-none absolute inset-0 -z-10 opacity-30 blur-3xl"
        style="background: radial-gradient(circle at 20% 20%, var(--color-primary), transparent 60%), radial-gradient(circle at 80% 30%, var(--color-secondary), transparent 55%);"
    ></div>

    <div class="flex flex-col items-start gap-6">
        <span class="flex items-center gap-2 border border-border bg-surface px-4 py-1.5 text-sm text-text-secondary" style="border-radius: var(--radius-base);">
            <svg class="h-4 w-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
            Verified Creator
        </span>

        <h1 class="font-heading text-5xl font-bold leading-[1.05] text-text-primary sm:text-6xl lg:text-7xl">
            Building a community,<br>one stream at a time.
        </h1>

        <p class="max-w-2xl font-body text-lg text-text-secondary">
            Full-time streamer and content creator turning games, community, and collaborations
            into a real business — this is the hub for fans, sponsors, and partners.
        </p>

        <div class="flex flex-wrap gap-4 pt-2">
            <a
                href="#live-status"
                data-magnetic
                class="bg-primary px-6 py-3 font-body font-semibold text-white transition hover:-translate-y-0.5"
                style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
            >
                Watch Live
            </a>
            <a
                href="#newsletter"
                data-magnetic
                class="border border-border px-6 py-3 font-body font-semibold text-text-primary transition hover:-translate-y-0.5"
                style="border-radius: var(--radius-base);"
            >
                Business Inquiries
            </a>
        </div>
    </div>
</x-section>
