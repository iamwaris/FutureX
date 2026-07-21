<?php

namespace App\Services\LiveStatus;

use App\Models\StreamingCredential;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Http;

/**
 * Uses YouTube Data API v3 with a plain API key (client_id column) — no
 * OAuth needed for public live-broadcast lookups. client_secret is unused
 * for this provider.
 */
class YouTubeLiveService implements LiveStatusProvider
{
    public function platformKey(): string
    {
        return 'youtube';
    }

    public function isConfigured(): bool
    {
        $credential = $this->credential();

        return $credential?->is_enabled
            && filled($credential->channel_id)
            && filled($credential->client_id);
    }

    public function fetchStatus(): LiveStreamStatus
    {
        $credential = $this->credential();

        if (! $credential) {
            return LiveStreamStatus::offline($this->platformKey());
        }

        $search = Http::get('https://www.googleapis.com/youtube/v3/search', [
            'part' => 'snippet',
            'channelId' => $credential->channel_id,
            'eventType' => 'live',
            'type' => 'video',
            'key' => $credential->client_id,
        ]);

        $liveVideo = $search->json('items.0');

        if (! $liveVideo) {
            return LiveStreamStatus::offline($this->platformKey());
        }

        $videoId = $liveVideo['id']['videoId'] ?? null;
        $details = $videoId ? $this->videoDetails($videoId, $credential->client_id) : null;

        return new LiveStreamStatus(
            platform: $this->platformKey(),
            isLive: true,
            title: $liveVideo['snippet']['title'] ?? null,
            viewerCount: isset($details['liveStreamingDetails']['concurrentViewers'])
                ? (int) $details['liveStreamingDetails']['concurrentViewers']
                : null,
            startedAt: isset($details['liveStreamingDetails']['actualStartTime'])
                ? CarbonImmutable::parse($details['liveStreamingDetails']['actualStartTime'])
                : null,
            watchUrl: $videoId ? "https://youtube.com/watch?v={$videoId}" : null,
        );
    }

    private function videoDetails(string $videoId, string $apiKey): ?array
    {
        $response = Http::get('https://www.googleapis.com/youtube/v3/videos', [
            'part' => 'liveStreamingDetails',
            'id' => $videoId,
            'key' => $apiKey,
        ]);

        return $response->json('items.0');
    }

    private function credential(): ?StreamingCredential
    {
        return StreamingCredential::forPlatform($this->platformKey());
    }
}
