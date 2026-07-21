@props(['id' => null, 'last' => false, 'band' => false])

@if ($band)
    <div style="background: var(--color-surface);">
@endif

<section
    @if ($id) id="{{ $id }}" @endif
    data-animate
    {{ $attributes->merge(['class' => 'mx-auto max-w-[1440px] px-6']) }}
    style="padding-block: calc(var(--section-spacing) / 2); {{ $last ? 'padding-bottom: var(--section-spacing);' : '' }}"
>
    {{ $slot }}
</section>

@if ($band)
    </div>
@endif
