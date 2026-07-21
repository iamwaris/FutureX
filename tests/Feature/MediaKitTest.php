<?php

namespace Tests\Feature;

use App\Models\MediaKit;
use App\Models\Sponsor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaKitTest extends TestCase
{
    use RefreshDatabase;

    public function test_media_kit_page_shows_bio_and_demographics(): void
    {
        MediaKit::current()->update([
            'bio' => 'A test creator bio.',
            'avg_viewers' => 1234,
            'age_ranges' => [['label' => '18-24', 'percentage' => 50]],
        ]);

        $response = $this->get('/media-kit');

        $response->assertOk();
        $response->assertSee('A test creator bio.');
        $response->assertSee('1,234');
        $response->assertSee('18-24');
    }

    public function test_media_kit_pdf_downloads_with_real_content(): void
    {
        MediaKit::current()->update(['bio' => 'PDF bio check.']);
        Sponsor::create(['name' => 'Test Sponsor', 'is_featured' => true, 'order' => 0]);

        $response = $this->get('/media-kit/pdf');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_sponsors_page_lists_sponsors_with_testimonials(): void
    {
        Sponsor::create([
            'name' => 'Aurora Gear',
            'testimonial_quote' => 'Fantastic partnership.',
            'testimonial_author' => 'Aurora Marketing',
            'is_featured' => true,
            'order' => 0,
        ]);

        $response = $this->get('/sponsors');

        $response->assertOk();
        $response->assertSee('Aurora Gear');
        $response->assertSee('Fantastic partnership.');
    }
}
