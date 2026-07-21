<div x-data="{ open: false, image: null, caption: null }">
    <div class="flex flex-wrap gap-2">
        <button
            type="button"
            wire:click="$set('category', '')"
            class="px-4 py-2 font-body text-sm transition {{ $category === '' ? 'bg-primary text-white' : 'cos-chip bg-surface text-text-secondary hover:text-text-primary' }}"
            style="border-radius: var(--radius-base);"
        >
            All
        </button>
        @foreach ($categories as $value => $label)
            <button
                type="button"
                wire:click="$set('category', '{{ $value }}')"
                class="px-4 py-2 font-body text-sm transition {{ $category === $value ? 'bg-primary text-white' : 'cos-chip bg-surface text-text-secondary hover:text-text-primary' }}"
                style="border-radius: var(--radius-base);"
            >
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div wire:loading.class="opacity-50" class="transition-opacity">
        @if ($items->isEmpty())
            <div class="cos-card mt-10 flex flex-col items-center gap-3 p-12 text-center">
                <x-ui-icon name="camera" solid class="h-8 w-8 text-text-muted" />
                <p class="font-heading text-lg font-semibold text-text-primary">No photos in this category yet</p>
            </div>
        @else
            <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($items as $item)
                    @php $url = $item->getFirstMediaUrl('image'); @endphp
                    <button
                        type="button"
                        x-on:click="open = true; image = '{{ $url ?: '' }}'; caption = @js($item->caption)"
                        class="group relative aspect-square overflow-hidden"
                        style="border-radius: var(--radius-base);"
                    >
                        @if ($url)
                            <img src="{{ $url }}" alt="{{ $item->caption }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div
                                class="flex h-full w-full items-center justify-center transition duration-500 group-hover:scale-105"
                                style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); opacity: 0.85;"
                            >
                                <x-ui-icon name="camera" solid class="h-6 w-6 text-white/70" />
                            </div>
                        @endif

                        @if ($item->caption)
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-2 opacity-0 transition group-hover:opacity-100">
                                <p class="font-body text-xs text-white">{{ $item->caption }}</p>
                            </div>
                        @endif
                    </button>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $items->links() }}
            </div>
        @endif
    </div>

    {{-- Lightbox --}}
    <div
        x-show="open"
        x-cloak
        x-on:keydown.escape.window="open = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-6"
        style="backdrop-filter: blur(4px);"
    >
        <button
            type="button"
            x-on:click="open = false"
            class="absolute right-6 top-6 text-white/70 hover:text-white"
            aria-label="Close"
        >
            <x-ui-icon name="arrow-right" class="h-8 w-8 rotate-45" />
        </button>

        <div class="max-h-full max-w-3xl" x-on:click.outside="open = false">
            <template x-if="image">
                <img :src="image" class="max-h-[80vh] w-auto" style="border-radius: var(--radius-base);">
            </template>
            <p class="mt-4 text-center font-body text-white/80" x-text="caption"></p>
        </div>
    </div>
</div>
