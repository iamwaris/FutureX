<?php

namespace Tests\Feature;

use App\Livewire\NewsletterForm;
use App\Models\NewsletterSetting;
use App\Services\Newsletter\NewsletterManager;
use App\Services\Newsletter\NewsletterSubscriptionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_throws_when_no_provider_configured(): void
    {
        $this->expectException(NewsletterSubscriptionException::class);

        (new NewsletterManager())->subscribe('fan@example.com');
    }

    public function test_manager_calls_beehiiv_when_configured(): void
    {
        NewsletterSetting::current()->update([
            'provider' => 'beehiiv',
            'api_key' => 'test-key',
            'list_id' => 'pub_123',
            'is_enabled' => true,
        ]);

        Http::fake([
            'api.beehiiv.com/*' => Http::response(['data' => ['id' => 'sub_123']], 201),
        ]);

        (new NewsletterManager())->subscribe('fan@example.com');

        Http::assertSent(fn ($request) => str_contains($request->url(), 'pub_123')
            && $request['email'] === 'fan@example.com');
    }

    public function test_manager_calls_mailchimp_when_configured(): void
    {
        NewsletterSetting::current()->update([
            'provider' => 'mailchimp',
            'api_key' => 'test-key-us21',
            'list_id' => 'list_123',
            'is_enabled' => true,
        ]);

        Http::fake([
            'us21.api.mailchimp.com/*' => Http::response(['id' => 'abc'], 200),
        ]);

        (new NewsletterManager())->subscribe('fan@example.com');

        Http::assertSent(fn ($request) => str_contains($request->url(), 'us21.api.mailchimp.com')
            && str_contains($request->url(), 'list_123'));
    }

    public function test_newsletter_form_shows_success_state_after_subscribing(): void
    {
        NewsletterSetting::current()->update([
            'provider' => 'beehiiv',
            'api_key' => 'test-key',
            'list_id' => 'pub_123',
            'is_enabled' => true,
        ]);

        Http::fake([
            'api.beehiiv.com/*' => Http::response(['data' => ['id' => 'sub_123']], 201),
        ]);

        Livewire::test(NewsletterForm::class)
            ->set('email', 'fan@example.com')
            ->call('subscribe')
            ->assertSet('subscribed', true)
            ->assertSee('check your inbox');
    }

    public function test_newsletter_form_validates_email(): void
    {
        Livewire::test(NewsletterForm::class)
            ->set('email', 'not-an-email')
            ->call('subscribe')
            ->assertHasErrors(['email']);
    }

    /**
     * The Beehiiv/Mailchimp list is the real subscriber list — this local
     * copy exists only so the admin Newsletter Growth widget has something
     * to chart without needing that provider's API.
     */
    public function test_a_successful_subscription_is_logged_locally_for_the_growth_widget(): void
    {
        NewsletterSetting::current()->update([
            'provider' => 'beehiiv',
            'api_key' => 'test-key',
            'list_id' => 'pub_123',
            'is_enabled' => true,
        ]);

        Http::fake([
            'api.beehiiv.com/*' => Http::response(['data' => ['id' => 'sub_123']], 201),
        ]);

        (new NewsletterManager())->subscribe('fan@example.com');

        $this->assertDatabaseHas('newsletter_subscriptions', [
            'email' => 'fan@example.com',
            'provider' => 'beehiiv',
        ]);
    }
}
