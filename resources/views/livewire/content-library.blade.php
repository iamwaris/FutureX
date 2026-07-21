<div>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-wrap gap-2">
            @foreach (['' => 'All', 'video' => 'Videos', 'clip' => 'Clips', 'short' => 'Shorts', 'vod' => 'VODs'] as $value => $label)
                <button
                    type="button"
                    wire:click="$set('type', '{{ $value }}')"
                    class="px-4 py-2 font-body text-sm transition {{ $type === $value ? 'bg-primary text-white' : 'cos-chip bg-surface text-text-secondary hover:text-text-primary' }}"
                    style="border-radius: var(--radius-base);"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="flex gap-3">
            <select
                wire:model.live="category"
                class="border bg-background px-3 py-2 font-body text-sm text-text-primary focus:outline-none"
                style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
            >
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>

            <input
                type="search"
                wire:model.live.debounce.300ms="search"
                placeholder="Search titles…"
                class="w-full border bg-background px-4 py-2 font-body text-sm text-text-primary placeholder:text-text-muted focus:outline-none sm:w-64"
                style="border-radius: var(--radius-base); border-color: color-mix(in srgb, var(--color-border) 70%, transparent);"
            >
        </div>
    </div>

    <div wire:loading.class="opacity-50" class="transition-opacity">
        @if ($videos->isEmpty())
            <div class="cos-card mt-10 flex flex-col items-center gap-3 p-12 text-center">
                <x-ui-icon name="eye" class="h-8 w-8 text-text-muted" />
                <p class="font-heading text-lg font-semibold text-text-primary">No content matches those filters</p>
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="font-body text-sm text-text-secondary underline hover:text-text-primary"
                >
                    Clear filters
                </button>
            </div>
        @else
            <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($videos as $video)
                    <div class="cos-card group overflow-hidden">
                        <div class="relative aspect-video overflow-hidden bg-surface">
                            <div
                                class="absolute inset-0 transition duration-500 group-hover:scale-105"
                                style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));"
                            ></div>

                            <div class="absolute left-2 top-2">
                                <x-platform-badge :name="$video->platform" size="sm" />
                            </div>

                            @if ($video->is_pinned)
                                <span
                                    class="absolute right-2 top-2 bg-primary px-2 py-0.5 text-[10px] font-semibold text-white"
                                    style="border-radius: calc(var(--radius-base) / 2);"
                                >
                                    Pinned
                                </span>
                            @endif

                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-3 pt-8">
                                <p class="font-body text-[10px] uppercase tracking-wide text-white/70">{{ $video->type }}</p>
                            </div>
                        </div>
                        <div class="p-4">
                            <p class="font-heading text-sm font-semibold leading-snug text-text-primary">{{ $video->title }}</p>
                            @if ($video->category)
                                <p class="mt-1 font-body text-xs text-text-muted">{{ $video->category }}</p>
                            @endif
                            @if (!empty($video->tags))
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @foreach (array_slice($video->tags, 0, 3) as $tag)
                                        <span class="bg-surface px-2 py-0.5 font-body text-[10px] text-text-muted" style="border-radius: calc(var(--radius-base) / 2);">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $videos->links() }}
            </div>
        @endif
    </div>
</div>
