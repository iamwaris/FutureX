@props(['name', 'size' => 'md'])

@php
    $config = [
        'twitch' => ['label' => 'Tw', 'class' => 'bg-[#9146FF] text-white'],
        'kick' => ['label' => 'Kk', 'class' => 'bg-[#53FC18] text-black'],
        'youtube' => ['label' => 'YT', 'class' => 'bg-[#FF0000] text-white'],
        'tiktok' => ['label' => 'Tt', 'class' => 'bg-black text-white'],
        'instagram' => ['label' => 'IG', 'class' => 'text-white', 'style' => 'background: linear-gradient(135deg, #F58529, #DD2A7B, #8134AF);'],
        'discord' => ['label' => 'Dc', 'class' => 'bg-[#5865F2] text-white'],
        'reddit' => ['label' => 'Rd', 'class' => 'bg-[#FF4500] text-white'],
        'x' => ['label' => 'X', 'class' => 'bg-black text-white'],
        'patreon' => ['label' => 'Pt', 'class' => 'bg-[#FF424D] text-white'],
        'kofi' => ['label' => 'Ko', 'class' => 'bg-[#FF5E5B] text-white'],
        'spotify' => ['label' => 'Sp', 'class' => 'bg-[#1DB954] text-black'],
    ];

    $item = $config[$name] ?? ['label' => '?', 'class' => 'bg-surface text-text-secondary'];
    $sizeClasses = $size === 'sm' ? 'h-6 w-6 text-[10px]' : 'h-9 w-9 text-xs';
@endphp

<span
    {{ $attributes->merge(['class' => "inline-flex shrink-0 items-center justify-center rounded-full font-heading font-bold {$sizeClasses} {$item['class']}"]) }}
    @if (isset($item['style'])) style="{{ $item['style'] }}" @endif
>
    {{ $item['label'] }}
</span>
