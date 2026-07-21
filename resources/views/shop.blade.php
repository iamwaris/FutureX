@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-[1440px] px-6" style="padding-block: var(--section-spacing);">
        <x-eyebrow icon="tag">Shop</x-eyebrow>
        <h1 class="font-heading text-4xl font-bold text-text-primary sm:text-5xl">Merch & Drops</h1>
        <p class="mt-4 max-w-2xl font-body text-lg text-text-secondary">
            Featured products, limited drops, and digital downloads — all in one place.
        </p>

        @if (empty($products))
            <div class="cos-card mt-10 flex flex-col items-center gap-3 p-12 text-center">
                <x-ui-icon name="tag" solid class="h-8 w-8 text-text-muted" />
                <p class="font-heading text-lg font-semibold text-text-primary">Shop coming soon</p>
            </div>
        @else
            <div class="mt-10 grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4">
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
    </div>
@endsection
