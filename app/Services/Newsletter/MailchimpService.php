<?php

namespace App\Services\Newsletter;

use App\Models\NewsletterSetting;
use Illuminate\Support\Facades\Http;

class MailchimpService implements NewsletterProvider
{
    public function __construct(private readonly NewsletterSetting $settings)
    {
    }

    public function subscribe(string $email): void
    {
        // Mailchimp API keys embed their datacenter as a suffix, e.g.
        // "abc123...-us21" — the API is hosted per-datacenter.
        $datacenter = str($this->settings->api_key)->afterLast('-')->toString();
        $subscriberHash = md5(strtolower($email));

        $response = Http::withBasicAuth('anystring', $this->settings->api_key)
            ->put(
                "https://{$datacenter}.api.mailchimp.com/3.0/lists/{$this->settings->list_id}/members/{$subscriberHash}",
                [
                    'email_address' => $email,
                    'status_if_new' => 'subscribed',
                    'status' => 'subscribed',
                ],
            );

        if ($response->failed()) {
            throw new NewsletterSubscriptionException(
                'Mailchimp subscription failed: '.($response->json('title') ?? $response->status())
            );
        }
    }
}
