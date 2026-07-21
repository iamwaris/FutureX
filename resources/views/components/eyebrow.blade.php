@props(['icon' => null])

<span
    class="cos-chip mb-4 inline-flex items-center gap-2 bg-surface px-4 py-1.5 text-sm text-text-secondary"
    style="border-radius: var(--radius-base);"
>
    @if ($icon)
        <x-ui-icon :name="$icon" class="h-4 w-4 text-primary" />
    @endif
    {{ $slot }}
</span>
