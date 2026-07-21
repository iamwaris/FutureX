<?php

namespace Tests\Feature;

use App\Models\AnalyticsSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsScriptsTest extends TestCase
{
    use RefreshDatabase;

    private function loadHomepage()
    {
        $this->seed(\Database\Seeders\PageSectionSeeder::class);

        return $this->get('/');
    }

    public function test_no_tracking_scripts_render_when_unconfigured(): void
    {
        $response = $this->loadHomepage();

        $response->assertDontSee('googletagmanager.com/gtag', false);
        $response->assertDontSee('clarity.ms', false);
        $response->assertDontSee('fbevents.js', false);
    }

    public function test_ga4_script_renders_only_when_configured(): void
    {
        AnalyticsSetting::current()->update(['ga4_measurement_id' => 'G-TEST123']);

        $response = $this->loadHomepage();

        $response->assertSee('googletagmanager.com/gtag/js?id=G-TEST123', false);
        $response->assertDontSee('clarity.ms', false);
        $response->assertDontSee('fbevents.js', false);
    }

    public function test_clarity_script_renders_only_when_configured(): void
    {
        AnalyticsSetting::current()->update(['clarity_project_id' => 'abc123']);

        $response = $this->loadHomepage();

        $response->assertSee('clarity.ms', false);
        $response->assertDontSee('googletagmanager.com/gtag', false);
        $response->assertDontSee('fbevents.js', false);
    }

    public function test_meta_pixel_script_renders_only_when_configured(): void
    {
        AnalyticsSetting::current()->update(['meta_pixel_id' => '123456789']);

        $response = $this->loadHomepage();

        $response->assertSee('fbevents.js', false);
        $response->assertSee('123456789', false);
        $response->assertDontSee('googletagmanager.com/gtag', false);
        $response->assertDontSee('clarity.ms', false);
    }

    public function test_all_three_scripts_render_together_when_all_configured(): void
    {
        AnalyticsSetting::current()->update([
            'ga4_measurement_id' => 'G-TEST123',
            'clarity_project_id' => 'abc123',
            'meta_pixel_id' => '123456789',
        ]);

        $response = $this->loadHomepage();

        $response->assertSee('googletagmanager.com/gtag', false);
        $response->assertSee('clarity.ms', false);
        $response->assertSee('fbevents.js', false);
    }
}
