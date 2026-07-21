<div class="w-full max-w-md">
    @if ($subscribed)
        <div
            class="cos-card flex items-center justify-center gap-2 px-6 py-3 font-body text-text-primary"
        >
            <x-ui-icon name="sparkles" solid class="h-5 w-5 text-primary" />
            You're in — check your inbox to confirm.
        </div>
    @else
        <form wire:submit="subscribe" class="flex flex-col gap-3 sm:flex-row">
            <div class="w-full flex-1">
                <label for="newsletter-email" class="sr-only">Email address</label>
                <input
                    id="newsletter-email"
                    type="email"
                    wire:model="email"
                    required
                    placeholder="you@example.com"
                    class="w-full border bg-background px-4 py-3 font-body text-text-primary placeholder:text-text-muted focus:outline-none"
                    style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
                >
                @error('email')
                    <p class="mt-1 font-body text-xs text-error">{{ $message }}</p>
                @enderror
            </div>
            <button
                type="submit"
                data-magnetic
                class="shrink-0 bg-primary px-6 py-3 font-body font-semibold text-white transition hover:-translate-y-0.5"
                style="border-radius: var(--radius-base);"
                wire:loading.attr="disabled"
                wire:target="subscribe"
            >
                <span wire:loading.remove wire:target="subscribe">Subscribe</span>
                <span wire:loading wire:target="subscribe">Subscribing…</span>
            </button>
        </form>

        @if ($error)
            <p class="mt-2 font-body text-sm text-error">{{ $error }}</p>
        @endif
    @endif
</div>
