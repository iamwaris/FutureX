<?php

namespace App\Services\LiveStatus;

use App\Models\StreamingCredential;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Http;

class TwitchService implements LiveStatusProvider
{
    public function platformKey(): string
    {
        return 'twitch';
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

        $response = Http::withHeaders([
            'Client-Id' => $credential->client_id,
            'Authorization' => "Bearer {$token}",
        ])->get('https://api.twitch.tv/helix/streams', [
            'user_id' => $credential->channel_id,
        ]);

        $stream = $response->json('data.0');

        if (! $stream) {
            return LiveStreamStatus::offline($this->platformKey());
        }

        return new LiveStreamStatus(
            platform: $this->platformKey(),
            isLive: true,
            title: $stream['title'] ?? null,
            category: $stream['game_name'] ?? null,
            viewerCount: $stream['viewer_count'] ?? null,
            startedAt: isset($stream['started_at']) ? CarbonImmutable::parse($stream['started_at']) : null,
            watchUrl: isset($stream['user_login']) ? "https://twitch.tv/{$stream['user_login']}" : null,
        );
    }

    /**
     * Twitch's Helix API needs an App Access Token (client_credentials grant)
     * for public read endpoints — cached on the credential row until it
     * expires so we're not re-authenticating on every poll.
     */
    private function accessToken(StreamingCredential $credential): string
    {
        if (
            $credential->cached_access_token
            && $credential->cached_access_token_expires_at?->isFuture()
        ) {
            return $credential->cached_access_token;
        }

        $response = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
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
