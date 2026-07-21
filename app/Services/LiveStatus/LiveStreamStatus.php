<?php

namespace App\Services\LiveStatus;

use Carbon\CarbonImmutable;

final readonly class LiveStreamStatus
{
    public function __construct(
        public string $platform,
        public bool $isLive,
        public ?string $title = null,
        public ?string $category = null,
        public ?int $viewerCount = null,
        public ?CarbonImmutable $startedAt = null,
        public ?string $watchUrl = null,
    ) {
    }

    public static function offline(string $platform): self
    {
        return new self(platform: $platform, isLive: false);
    }

    public function durationForHumans(): ?string
    {
        return $this->startedAt?->diffForHumans(null, true);
    }
}
