<?php

namespace App\Services\Newsletter;

interface NewsletterProvider
{
    /**
     * @throws NewsletterSubscriptionException on a failed API call — the
     * caller decides how to present that to the visitor.
     */
    public function subscribe(string $email): void;
}
