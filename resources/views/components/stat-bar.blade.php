@props(['label', 'percentage'])

<div>
    <div class="flex items-center justify-between font-body text-sm">
        <span class="text-text-secondary">{{ $label }}</span>
        <span class="font-semibold text-text-primary">{{ $percentage }}%</span>
    </div>
    <div class="mt-1.5 h-2 w-full overflow-hidden bg-surface" style="border-radius: 999px;">
        <div
            class="h-full bg-primary"
            style="width: {{ $percentage }}%; border-radius: 999px;"
        ></div>
    </div>
</div>
