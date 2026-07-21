<x-section id="newsletter" :last="true">
    <div
        class="relative flex flex-col items-center gap-6 overflow-hidden border p-12 text-center"
        style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
    >
        <div
            class="pointer-events-none absolute inset-0 -z-10 opacity-20 blur-3xl"
            style="background: radial-gradient(circle at 50% 0%, var(--color-primary), transparent 60%);"
        ></div>

        <x-eyebrow icon="sparkles">Newsletter</x-eyebrow>
        <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Join the Inner Circle</h2>
        <p class="max-w-lg font-body text-text-secondary">
            Behind-the-scenes updates, early access to drops, and stream announcements — straight to
            your inbox, no spam.
        </p>

        @livewire('newsletter-form')
    </div>
</x-section>
