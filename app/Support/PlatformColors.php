<?php

namespace App\Support;

/**
 * Single source of truth for per-platform brand colors, shared between
 * <x-platform-badge> and anywhere else (like Community Hub's per-card
 * hover glow) that needs the same color without duplicating the map.
 */
class PlatformColors
{
    private const COLORS = [
        'twitch' => '#9146FF',
        'kick' => '#53FC18',
        'youtube' => '#FF0000',
        'tiktok' => '#25F4EE',
        'instagram' => '#DD2A7B',
        'discord' => '#5865F2',
        'reddit' => '#FF4500',
        'x' => '#000000',
        'patreon' => '#FF424D',
        'kofi' => '#FF5E5B',
        'spotify' => '#1DB954',
    ];

    public static function hex(string $platform): string
    {
        return self::COLORS[$platform] ?? '#71717A';
    }
}
