<div>
    @if ($submitted)
        <div class="cos-card flex flex-col items-center gap-3 p-10 text-center">
            <x-ui-icon name="sparkles" solid class="h-8 w-8 text-primary" />
            <p class="font-heading text-xl font-semibold text-text-primary">Thanks — that's in.</p>
            <p class="max-w-md font-body text-text-secondary">We'll get back to you within 48 hours.</p>
        </div>
    @else
        <form wire:submit="submit" class="cos-card flex flex-col gap-5 p-8">
            {{-- Honeypot: hidden from sighted users and screen readers alike. --}}
            <div class="absolute -left-[9999px]" aria-hidden="true">
                <label for="website">Website</label>
                <input type="text" id="website" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-1.5 block font-body text-sm text-text-secondary">Name *</label>
                    <input
                        id="name" type="text" wire:model="name"
                        class="w-full border bg-background px-4 py-2.5 font-body text-text-primary focus:outline-none"
                        style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
                    >
                    @error('name') <p class="mt-1 font-body text-xs text-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="company" class="mb-1.5 block font-body text-sm text-text-secondary">Company</label>
                    <input
                        id="company" type="text" wire:model="company"
                        class="w-full border bg-background px-4 py-2.5 font-body text-text-primary focus:outline-none"
                        style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
                    >
                </div>

                <div>
                    <label for="email" class="mb-1.5 block font-body text-sm text-text-secondary">Email *</label>
                    <input
                        id="email" type="email" wire:model="email"
                        class="w-full border bg-background px-4 py-2.5 font-body text-text-primary focus:outline-none"
                        style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
                    >
                    @error('email') <p class="mt-1 font-body text-xs text-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="campaign_type" class="mb-1.5 block font-body text-sm text-text-secondary">Campaign Type *</label>
                    <select
                        id="campaign_type" wire:model="campaign_type"
                        class="w-full border bg-background px-4 py-2.5 font-body text-text-primary focus:outline-none"
                        style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
                    >
                        <option value="">Select one…</option>
                        <option value="sponsorship">Sponsorship</option>
                        <option value="product-placement">Product Placement</option>
                        <option value="event">Event Appearance</option>
                        <option value="other">Other</option>
                    </select>
                    @error('campaign_type') <p class="mt-1 font-body text-xs text-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="budget" class="mb-1.5 block font-body text-sm text-text-secondary">Budget</label>
                    <input
                        id="budget" type="text" wire:model="budget" placeholder="e.g. $5,000 – $10,000"
                        class="w-full border bg-background px-4 py-2.5 font-body text-text-primary placeholder:text-text-muted focus:outline-none"
                        style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
                    >
                </div>

                <div>
                    <label for="timeline" class="mb-1.5 block font-body text-sm text-text-secondary">Timeline</label>
                    <input
                        id="timeline" type="text" wire:model="timeline" placeholder="e.g. Q4 2026"
                        class="w-full border bg-background px-4 py-2.5 font-body text-text-primary placeholder:text-text-muted focus:outline-none"
                        style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
                    >
                </div>
            </div>

            <div>
                <label for="message" class="mb-1.5 block font-body text-sm text-text-secondary">Message *</label>
                <textarea
                    id="message" wire:model="message" rows="5"
                    class="w-full border bg-background px-4 py-2.5 font-body text-text-primary focus:outline-none"
                    style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
                ></textarea>
                @error('message') <p class="mt-1 font-body text-xs text-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="attachment" class="mb-1.5 block font-body text-sm text-text-secondary">Attachment (optional)</label>
                <input
                    id="attachment" type="file" wire:model="attachment"
                    class="w-full font-body text-sm text-text-secondary"
                >
                @error('attachment') <p class="mt-1 font-body text-xs text-error">{{ $message }}</p> @enderror
            </div>

            <button
                type="submit"
                class="self-start bg-primary px-6 py-3 font-body font-semibold text-white transition hover:-translate-y-0.5"
                style="border-radius: var(--radius-base);"
                wire:loading.attr="disabled"
                wire:target="submit"
            >
                <span wire:loading.remove wire:target="submit">Send Inquiry</span>
                <span wire:loading wire:target="submit">Sending…</span>
            </button>
        </form>
    @endif
</div>
