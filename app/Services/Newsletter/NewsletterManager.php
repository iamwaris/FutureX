<?php

namespace App\Services\Newsletter;

use App\Models\NewsletterSetting;
use App\Models\NewsletterSubscription;

class NewsletterManager
{
    /**
     * @throws NewsletterSubscriptionException if no provider is configured
     * or the provider's API call fails.
     */
    public function subscribe(string $email): void
    {
        $settings = NewsletterSetting::current();

        if (! $settings->is_enabled || $settings->provider === 'none') {
            throw new NewsletterSubscriptionException('Newsletter is not configured yet.');
        }

        $provider = match ($settings->provider) {
            'beehiiv' => new BeehiivService($settings),
            'mailchimp' => new MailchimpService($settings),
            default => throw new NewsletterSubscriptionException("Unknown newsletter provider: {$settings->provider}"),
        };

        $provider->subscribe($email);

        // The provider (Beehiiv/Mailchimp) is the real subscriber list —
        // this local copy exists only so the admin Newsletter Growth
        // widget has something to chart without needing that provider's API.
        NewsletterSubscription::create([
            'email' => $email,
            'provider' => $settings->provider,
        ]);
    }
}
