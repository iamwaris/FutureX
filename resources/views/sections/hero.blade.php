<x-section id="hero" class="relative overflow-hidden">
    {{-- Dot-grid + gradient mesh backdrop, all derived from brand tokens. --}}
    <div
        class="pointer-events-none absolute inset-0 -z-20"
        style="background-image: radial-gradient(var(--color-border) 1px, transparent 1px); background-size: 28px 28px; mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, black 40%, transparent 100%);"
    ></div>
    <div
        class="pointer-events-none absolute inset-0 -z-10 opacity-30 blur-3xl"
        style="background: radial-gradient(circle at 20% 20%, var(--color-primary), transparent 60%), radial-gradient(circle at 80% 30%, var(--color-secondary), transparent 55%);"
    ></div>

    <div class="grid grid-cols-1 items-center gap-16 lg:grid-cols-12">
        <div class="flex flex-col items-start gap-6 lg:col-span-7">
            <span class="cos-chip flex items-center gap-2 bg-surface px-4 py-1.5 text-sm text-text-secondary" style="border-radius: var(--radius-base);">
                <svg class="h-4 w-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                Verified Creator
            </span>

            <h1 class="font-heading text-5xl font-bold leading-[1.05] tracking-tight text-text-primary sm:text-6xl lg:text-7xl">
                Building a
                <span
                    style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); -webkit-background-clip: text; background-clip: text; color: transparent;"
                >community</span>,<br>one stream at a time.
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
                    href="{{ route('contact') }}"
                    data-magnetic
                    class="border px-6 py-3 font-body font-semibold text-text-primary transition hover:-translate-y-0.5"
                    style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
                >
                    Business Inquiries
                </a>
            </div>
        </div>

        <div class="relative lg:col-span-5">
            {{-- Stylized stream-preview card instead of a stock photo — no real creator media exists yet. --}}
            @livewire('hero-live-status')

            <div
                class="cos-card absolute -bottom-6 -left-6 hidden items-center gap-3 p-4 sm:flex"
            >
                <span class="flex h-10 w-10 items-center justify-center bg-primary/10 text-primary" style="border-radius: calc(var(--radius-base) / 2);">
                    <x-ui-icon name="sparkles" solid class="h-5 w-5" />
                </span>
                <div>
                    <p class="font-heading text-sm font-bold text-text-primary">128K</p>
                    <p class="font-body text-xs text-text-muted">Followers</p>
                </div>
            </div>
        </div>
    </div>
</x-section>
