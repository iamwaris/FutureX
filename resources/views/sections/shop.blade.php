@php
    $products = [
        ['name' => 'Signature Hoodie', 'price' => '$58', 'badge' => 'Limited Drop'],
        ['name' => 'Logo Tee', 'price' => '$28', 'badge' => null],
        ['name' => 'Desk Mat', 'price' => '$22', 'badge' => null],
        ['name' => 'Discord Emote Pack', 'price' => '$5', 'badge' => 'Digital'],
    ];
@endphp

<x-section id="shop">
    <div class="flex items-baseline justify-between">
        <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Shop</h2>
        <a href="#" class="font-body text-sm text-text-secondary hover:text-text-primary">View all →</a>
    </div>

    <div class="mt-10 grid grid-cols-2 gap-6 lg:grid-cols-4">
        @foreach ($products as $product)
            <div
                class="overflow-hidden border border-border bg-card"
                style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
            >
                <div class="relative aspect-square bg-surface">
                    @if ($product['badge'])
                        <span
                            class="absolute left-3 top-3 bg-secondary px-2.5 py-1 text-xs font-semibold text-white"
                            style="border-radius: calc(var(--radius-base) / 2);"
                        >
                            {{ $product['badge'] }}
                        </span>
                    @endif
                </div>
                <div class="p-4">
                    <p class="font-heading text-sm font-semibold text-text-primary">{{ $product['name'] }}</p>
                    <p class="mt-1 font-body text-sm text-text-muted">{{ $product['price'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</x-section>
