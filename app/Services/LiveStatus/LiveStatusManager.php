<?php

namespace App\Services\LiveStatus;

use Illuminate\Support\Facades\Cache;

class LiveStatusManager
{
    public const CACHE_KEY = 'live-status:current';

    /**
     * @param  LiveStatusProvider[]  $providers
     */
    public function __construct(private readonly array $providers)
    {
    }

    /**
     * Called by the scheduled polling command. Checks every configured
     * provider and caches whichever is actually live (first match wins —
     * a creator streaming to multiple platforms simultaneously is rare
     * enough not to need priority ordering yet). Caches an explicit
     * "offline" status if nothing is live, so the frontend always has
     * something to read instead of falling through to stale data.
     */
    public function refresh(): LiveStreamStatus
    {
        foreach ($this->providers as $provider) {
            if (! $provider->isConfigured()) {
                continue;
            }

            $status = $provider->fetchStatus();

            if ($status->isLive) {
                Cache::put(self::CACHE_KEY, $status, now()->addMinutes(5));

                return $status;
            }
        }

        $offline = LiveStreamStatus::offline('none');
        Cache::put(self::CACHE_KEY, $offline, now()->addMinutes(5));

        return $offline;
    }

    /**
     * Called by the frontend — always reads the cache, never hits a
     * platform API directly, so page loads stay fast regardless of
     * third-party API latency.
     */
    public function current(): LiveStreamStatus
    {
        return Cache::get(self::CACHE_KEY) ?? LiveStreamStatus::offline('none');
    }
}
