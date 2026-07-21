<?php

namespace App\Services\LiveStatus;

use App\Models\StreamingCredential;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Http;

/**
 * Built against Kick's public API v1 (api.kick.com/public/v1), which uses
 * the same OAuth2 client_credentials flow as Twitch. Kick's API surface has
 * changed shape more than once historically — verify endpoint/response
 * fields against their current docs when real credentials are added.
 */
class KickService implements LiveStatusProvider
{
    public function platformKey(): string
    {
        return 'kick';
    }

    public function isConfigured(): bool
    {
        $credential = $this->credential();

        return $credential?->is_enabled
            && filled($credential->channel_id)
            && filled($credential->client_id)
            && filled($credential->client_secret);
    }

    public function fetchStatus(): LiveStreamStatus
    {
        $credential = $this->credential();

        if (! $credential) {
            return LiveStreamStatus::offline($this->platformKey());
        }

        $token = $this->accessToken($credential);

        $response = Http::withToken($token)
            ->get('https://api.kick.com/public/v1/channels', [
                'slug' => $credential->channel_id,
            ]);

        $channel = $response->json('data.0');
        $stream = $channel['stream'] ?? null;

        if (! $stream || ! ($stream['is_live'] ?? false)) {
            return LiveStreamStatus::offline($this->platformKey());
        }

        return new LiveStreamStatus(
            platform: $this->platformKey(),
            isLive: true,
            title: $channel['stream_title'] ?? null,
            category: $channel['category']['name'] ?? null,
            viewerCount: $stream['viewer_count'] ?? null,
            startedAt: isset($stream['start_time']) ? CarbonImmutable::parse($stream['start_time']) : null,
            watchUrl: "https://kick.com/{$credential->channel_id}",
        );
    }

    private function accessToken(StreamingCredential $credential): string
    {
        if (
            $credential->cached_access_token
            && $credential->cached_access_token_expires_at?->isFuture()
        ) {
            return $credential->cached_access_token;
        }

        $response = Http::asForm()->post('https://id.kick.com/oauth/token', [
            'client_id' => $credential->client_id,
            'client_secret' => $credential->client_secret,
            'grant_type' => 'client_credentials',
        ]);

        $token = $response->json('access_token');
        $expiresIn = $response->json('expires_in', 0);

        $credential->update([
            'cached_access_token' => $token,
            'cached_access_token_expires_at' => now()->addSeconds($expiresIn),
        ]);

        return $token;
    }

    private function credential(): ?StreamingCredential
    {
        return StreamingCredential::forPlatform($this->platformKey());
    }
}
