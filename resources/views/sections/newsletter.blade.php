<x-section id="newsletter" :last="true">
    <div
        class="flex flex-col items-center gap-6 border border-border bg-card p-12 text-center"
        style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
    >
        <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Join the Inner Circle</h2>
        <p class="max-w-lg font-body text-text-secondary">
            Behind-the-scenes updates, early access to drops, and stream announcements — straight to
            your inbox, no spam.
        </p>

        <form class="flex w-full max-w-md flex-col gap-3 sm:flex-row" onsubmit="return false;">
            <input
                type="email"
                required
                placeholder="you@example.com"
                class="w-full flex-1 border border-border bg-background px-4 py-3 font-body text-text-primary placeholder:text-text-muted focus:outline-none"
                style="border-radius: var(--radius-base);"
            >
            <button
                type="submit"
                class="bg-primary px-6 py-3 font-body font-semibold text-white transition hover:-translate-y-0.5"
                style="border-radius: var(--radius-base);"
            >
                Subscribe
            </button>
        </form>
    </div>
</x-section>
