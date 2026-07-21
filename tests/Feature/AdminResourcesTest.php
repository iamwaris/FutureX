<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminResourcesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider contentResourcePaths
     */
    public function test_content_resource_index_loads(string $path): void
    {
        $this->actingAs(User::factory()->create())
            ->get("/admin/{$path}")
            ->assertOk();
    }

    public static function contentResourcePaths(): array
    {
        return [
            ['page-sections'],
            ['videos'],
            ['gallery-items'],
            ['events'],
            ['faq-items'],
            ['posts'],
            ['streaming-credentials'],
            ['community-links'],
            ['sponsors'],
            ['business-inquiries'],
            ['shop-credentials'],
            ['products'],
            ['theme-presets'],
        ];
    }

    /**
     * @dataProvider settingsPagePaths
     */
    public function test_settings_page_loads(string $path): void
    {
        $this->actingAs(User::factory()->create())
            ->get("/admin/{$path}")
            ->assertOk();
    }

    public static function settingsPagePaths(): array
    {
        return [
            ['theme-builder'],
            ['snapshot-stats-settings'],
            ['newsletter-settings-page'],
            ['media-kit-settings'],
            ['mode-switcher'],
            ['analytics-settings-page'],
        ];
    }

    public function test_dashboard_loads_with_its_widgets(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertOk();
    }
}
