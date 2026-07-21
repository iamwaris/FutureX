<?php

namespace App\Services\Newsletter;

use App\Models\NewsletterSetting;
use Illuminate\Support\Facades\Http;

class BeehiivService implements NewsletterProvider
{
    public function __construct(private readonly NewsletterSetting $settings)
    {
    }

    public function subscribe(string $email): void
    {
        $response = Http::withToken($this->settings->api_key)
            ->post("https://api.beehiiv.com/v2/publications/{$this->settings->list_id}/subscriptions", [
                'email' => $email,
                'reactivate_existing' => true,
            ]);

        if ($response->failed()) {
            throw new NewsletterSubscriptionException(
                'Beehiiv subscription failed: '.($response->json('message') ?? $response->status())
            );
        }
    }
}
