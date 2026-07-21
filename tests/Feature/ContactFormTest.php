<?php

namespace Tests\Feature;

use App\Livewire\ContactForm;
use App\Models\BusinessInquiry;
use App\Notifications\NewBusinessInquiryNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(): array
    {
        return [
            'name' => 'Jamie Sponsor',
            'company' => 'Aurora Gear',
            'email' => 'jamie@example.com',
            'campaign_type' => 'sponsorship',
            'budget' => '$5,000 - $10,000',
            'timeline' => 'Q4 2026',
            'message' => 'We would love to run a campaign with you.',
        ];
    }

    public function test_a_legitimate_submission_creates_an_inquiry_and_notifies(): void
    {
        Notification::fake();

        Livewire::test(ContactForm::class)
            ->set('renderedAt', microtime(true) - 10) // form has been "open" a while
            ->set($this->validPayload())
            ->call('submit')
            ->assertSet('submitted', true)
            ->assertSee('Thanks');

        $this->assertDatabaseHas('business_inquiries', [
            'email' => 'jamie@example.com',
            'campaign_type' => 'sponsorship',
        ]);

        Notification::assertSentOnDemand(NewBusinessInquiryNotification::class);
    }

    public function test_validation_requires_name_email_campaign_type_and_message(): void
    {
        Livewire::test(ContactForm::class)
            ->set('renderedAt', microtime(true) - 10)
            ->call('submit')
            ->assertHasErrors(['name', 'email', 'campaign_type', 'message']);

        $this->assertDatabaseCount('business_inquiries', 0);
    }

    public function test_honeypot_field_silently_blocks_submission(): void
    {
        Notification::fake();

        Livewire::test(ContactForm::class)
            ->set('renderedAt', microtime(true) - 10)
            ->set($this->validPayload())
            ->set('website', 'https://spam-bot.example')
            ->call('submit')
            ->assertSet('submitted', true); // looks successful to the bot

        $this->assertDatabaseCount('business_inquiries', 0);
        Notification::assertNothingSent();
    }

    public function test_submitting_too_quickly_after_render_is_silently_blocked(): void
    {
        Notification::fake();

        // renderedAt defaults to "now" via mount() — submitting immediately
        // after should look like a bot that fills the form instantly.
        Livewire::test(ContactForm::class)
            ->set($this->validPayload())
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertDatabaseCount('business_inquiries', 0);
        Notification::assertNothingSent();
    }
}
