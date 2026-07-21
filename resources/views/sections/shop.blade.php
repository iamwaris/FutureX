@php
    $products = array_slice(app(\App\Services\Shop\ShopManager::class)->products(), 0, 4);
@endphp

<x-section id="shop">
    <div class="flex items-end justify-between">
        <div>
            <x-eyebrow icon="tag">Merch</x-eyebrow>
            <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">Shop</h2>
        </div>
        <a href="{{ route('shop') }}" class="flex items-center gap-1 font-body text-sm text-text-secondary hover:text-text-primary">
            View all <x-ui-icon name="arrow-right" class="h-4 w-4" />
        </a>
    </div>

    @if (empty($products))
        <p class="mt-10 font-body text-text-muted">Shop coming soon.</p>
    @else
        <div class="mt-10 grid grid-cols-2 gap-6 lg:grid-cols-4">
            @foreach ($products as $product)
                <a href="{{ $product->trackedUrl() }}" target="_blank" rel="noopener" class="cos-card group overflow-hidden">
                    <div class="relative flex aspect-square items-center justify-center overflow-hidden bg-surface">
                        @if ($product->imageUrl)
                            <img src="{{ $product->imageUrl }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <x-ui-icon
                                :name="$product->isDigital ? 'download' : 'tag'"
                                solid
                                class="h-10 w-10 text-text-muted transition group-hover:scale-110 group-hover:text-primary"
                            />
                        @endif

                        @if ($product->isLimited)
                            <span class="absolute left-3 top-3 bg-secondary px-2.5 py-1 text-xs font-semibold text-white" style="border-radius: calc(var(--radius-base) / 2);">
                                Limited Drop
                            </span>
                        @elseif ($product->isDigital)
                            <span class="absolute left-3 top-3 bg-secondary px-2.5 py-1 text-xs font-semibold text-white" style="border-radius: calc(var(--radius-base) / 2);">
                                Digital
                            </span>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="font-heading text-sm font-semibold text-text-primary">{{ $product->name }}</p>
                        <p class="mt-1 font-body text-sm text-text-muted">{{ $product->priceFormatted }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-section>
