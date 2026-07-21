<?php

namespace App\Services\Newsletter;

use App\Models\NewsletterSetting;

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
    }
}
