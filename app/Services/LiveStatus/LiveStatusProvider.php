<?php

namespace App\Services\LiveStatus;

interface LiveStatusProvider
{
    /**
     * The value stored in streaming_credentials.platform for this provider.
     */
    public function platformKey(): string;

    /**
     * Whether an admin has entered enough credentials in Filament
     * Integrations for this provider to be worth calling.
     */
    public function isConfigured(): bool;

    /**
     * Hits the real platform API. Callers should go through
     * LiveStatusManager rather than calling this directly, so caching
     * and provider-selection stay in one place.
     */
    public function fetchStatus(): LiveStreamStatus;
}
